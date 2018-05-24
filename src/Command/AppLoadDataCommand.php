<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\Movie;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppLoadDataCommand extends Command
{
    protected static $defaultName = 'app:load-data';

    protected $em;
    protected $encoder;

    public function __construct(string $name = null,
                                EntityManagerInterface $em,
                                UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Load dummy data in database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $io = new SymfonyStyle($input, $output);

        //instancie faker
        $faker = \Faker\Factory::create('fr_FR');

        try {
            //exécute une bonne vieille requête SQL pour vider la table
            $this->em->getConnection()->exec("TRUNCATE review");
        }
        catch (\Exception $e) {
            $io->error($e->getMessage());
        }


        $num = $io->askQuestion(new Question('how many User ?'));
        $io->progressStart($num);
        for ($i=0; $i<$num; $i++) {
            //Créer une instance
            $author = new User();
            //Hydrater l'instance
            $author->setUsername($faker->userName);
            $author->setEmail($faker->email);
            $author->setEmail($faker->email);
            $encoded = $this->encoder->encodePassword($author, $faker->password);
            $author->setPassword($encoded);
            $author->setRoles(["ROLE_USER"]);
            $author->setDateCreated($faker->dateTimeBetween("-2 years"));

            //on demande de sauvegarder notre objet
            $this->em->persist($author);
            $io->progressAdvance();
        }

        $io->progressFinish();

        //exécute la requête
        $this->em->flush();
        $io->success('OK for the Users !');

        $num = $io->askQuestion(new Question('how many reviews ?'));

        //récupère les 50 premier films
        $movieRepo = $this->em->getRepository(Movie::class);
        $movies = $movieRepo->findBy([], ["rating" => "DESC"], 50);

        //récupère les 150 users
        $authorRepo = $this->em->getRepository(User::class);
        $authors = $authorRepo->findBy([], [], 150);


        $io->progressStart($num);
        for ($i=0; $i<$num; $i++) {
            //Créer une instance
            $review = new Review();
            //Hydrater l'instance
            $review->setTitle($faker->sentence);
            $review->setContent($faker->text(1000));
            $review->setDateCreated($faker->dateTimeBetween("-2 years"));

            //associe la review à un film au hasard
            shuffle($movies);
            $movie = $movies[0];
            $review->setMovie($movie);

            shuffle($authors);
            $author = $authors[0];
            $review->setAuthor($author);

            //on demande de sauvegarder notre objet
            $this->em->persist($review);
            $io->progressAdvance();
        }
        $io->progressFinish();

        //exécute la requête
        $this->em->flush();
        $io->success('Gemacht !');

//        $io = new SymfonyStyle($input, $output);
//        $response = $io->askQuestion(new Question('coucou ?'));
//        $io->caution($response);
//        $io->writeln('coucou');
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
