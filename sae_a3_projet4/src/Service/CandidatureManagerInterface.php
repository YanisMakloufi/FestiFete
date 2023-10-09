<?php

namespace App\Service;

use App\Entity\Candidature;
use Symfony\Component\HttpFoundation\RequestStack;

interface CandidatureManagerInterface
{
    public function verifierCandidature(Candidature $candidature, RequestStack $requestStack) : bool;
}