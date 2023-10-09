<?php

namespace App\Service;

use App\Entity\Festival;
use Symfony\Component\HttpFoundation\RequestStack;

interface FestivalManagerInterface
{
    public function verifierFestival(Festival $festival, RequestStack $requestStack) : bool;
}