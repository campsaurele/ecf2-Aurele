<?php

namespace App\Controller;

use App\Repository\AbsencesRepository;
use App\Repository\TraineeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatisticsController extends AbstractController
{
    public function statistics(
        TraineeRepository $traineeRepository,
        AbsencesRepository $absencesRepository,
    ): Response {
        $dailyAmount = 712 / 21;

        $trainees = $traineeRepository->findAll();

        $countWithoutReason = [];
        $salaryLoss = [];
        foreach ($trainees as $trainee) {
            $countWithoutReason[$trainee->getId()] =
                $absencesRepository->countWithoutReason($trainee);
            $salaryLoss[$trainee->getId()] = $absencesRepository->countAbsence($trainee) * $dailyAmount;
        }

        return $this->render('partials/statistic.html.twig', [
            'trainees' => $trainees,
            'countWithoutReason' => $countWithoutReason,
            'salaryLoss' => $salaryLoss,
        ]);
    }
}
