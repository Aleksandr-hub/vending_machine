<?php

namespace App\Command;

use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:insert_coins_command',
    description: 'This command allows you to insert coins into the vending machine.',
)]
class InsertCoinsCommand extends Command
{

    private $orderService;

    private $entityManager;

    public function __construct(OrderService $orderService, EntityManagerInterface $entityManager)
    {
        $this->orderService = $orderService;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Accept coins into vending machine')
            ->setHelp('This command allows you to insert coins into the vending machine.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $output->writeln('Please insert coins into the vending machine.');

        $coinsAccepted = [0.01, 0.05, 0.10, 0.25, 0.50, 1.00];
        $totalAmount = 0;

        $order = $this->orderService->getLatestUnfulfilledOrder();
        $product = $order->getProduct();
        $price = $product->getPrice();
        while (true) {
            $question = new Question('Enter coin value (0.01, 0.05, 0.10, 0.25, 0.50, 1.00): ');

            $coin = $helper->ask($input, $output, $question);

            if (!in_array($coin, $coinsAccepted)) {
                $output->writeln('Invalid coin. Accepted coins: 0.01, 0.05, 0.10, 0.25, 0.50, 1.00');
                return Command::FAILURE;
            }

            $totalAmount += $coin;
            if ($price <= $totalAmount) {
                // Покупка продукту
                $output->writeln(sprintf('Buying product: %s for %.2f', $product->getName(), $price));

                // Обчислення здачі
                $change = $totalAmount - $price;
                $output->writeln(sprintf('Change: %.2f', $change));

                // Видача продукту
                $output->writeln(sprintf('Dispensing product: %s', $product->getName()));

                // Повернення здачі
                $this->returnChange($output, $change);

                // Зберігання замовлення в базі даних
                $order->setIsFulfilled(true);
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                return Command::SUCCESS;
            }

            $output->writeln(sprintf('Accepted coin: %.2f', $coin));
            $output->writeln(sprintf('Total amount: %.2f', $totalAmount));
        }

        return Command::SUCCESS;
    }

    private function returnChange(OutputInterface $output, $change): void
    {
        $coins = [1.00, 0.50, 0.25, 0.10, 0.05, 0.01];
        $changeLeft = $change;

        foreach ($coins as $coin) {
            $coinCount = floor($changeLeft / $coin);

            if ($coinCount > 0) {
                $output->writeln(sprintf('Returned %.2f x %d', $coin, $coinCount));
                $changeLeft -= $coin * $coinCount;
            }

            if ($changeLeft <= 0.001) {
                break; // Зупиняємо цикл, якщо здача вичерпана
            }
        }
    }
}
