<?php

namespace App\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\Basket;

class BasketExtension extends AbstractExtension
{
    protected $doctrine;
    protected $session;

    public function __construct(ManagerRegistry $doctrine,Security $session)
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('format_price_rub', [$this, 'formatPriceToRub']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('basket_total_price', [$this, 'basketTotalPrice']),
        ];
    }

    public function formatPriceToRub($price){
        $thousandPrice = $price/1000;
        $overPrice = $price%1000;
        if($overPrice == 0){
            $overPrice = "000";
        }
        return $thousandPrice.",".$overPrice." руб.";
    }
    public function basketTotalPrice()
    {
        $currentUser = $this->session->getUser();
        $totalPrice = $this->doctrine
            ->getRepository(Basket::class)
            ->getTotalPriceBasketForCurrentUser($currentUser);

        return $totalPrice;
    }
}
