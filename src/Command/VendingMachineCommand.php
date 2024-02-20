<?php

namespace App\Command;

use App\Entity\Order;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:vending-machine',
    description: 'List and buy products',
)]
class VendingMachineCommand extends Command
{
    private $productService;

    private $entityManager;

    public function __construct(ProductService $productService, EntityManagerInterface $entityManager)
    {
        $this->productService = $productService;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Vending Machine Command')
            ->setHelp('This command allows you to interact with the vending machine.')
            ->addArgument('action', InputArgument::REQUIRED, 'Action to perform (list|buy)')
            ->addOption('product', 'p', InputOption::VALUE_OPTIONAL, 'Product name')
            ->addOption('select', null, InputOption::VALUE_NONE, 'Show the price of the selected product');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $action = $input->getArgument('action');
        $productName = $input->getOption('product');
        switch ($action) {
            case 'list':
                $this->listProducts($output);
                break;
            case 'select':
                $this->showProduct($output, $productName);
                break;
            default:
                $output->writeln('Invalid action. Available actions: list, buy');
        }

        return Command::SUCCESS;
    }

    private function listProducts(OutputInterface $output): void
    {
        $products = $this->productService->getAllProducts();

        if (empty($products)) {
            $output->writeln('No products available.');
        } else {
            $output->writeln('Available products:');
            foreach ($products as $product) {
                $output->writeln(sprintf('%s - %.2f', $product->getName(), $product->getPrice()));
            }
        }
    }

    private function showProduct(OutputInterface $output, $productName): void
    {
        $product = $this->productService->getProductByName($productName);

        $price = $product->getPrice();

        if ($price === null) {
            $output->writeln(sprintf('<error>Product "%s" does not exist.</error>', $productName));
            return;
        }

        // Створення нового замовлення
        $order = new Order();
        $order->setProduct($product);

        // Зберігання замовлення в базі даних
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $output->writeln(sprintf('<info>The price of "%s" is $%s.</info>', $productName, number_format($price, 2)));

    }
}