<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use App\Entity\User;
use App\Entity\Commande;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*############################################################
         *                    LES CATEGORIES
        ############################################################*/

        $categorie1 = new Categorie ();

        $categorie1 -> setLibelle ("Milkshake");
        $categorie1 -> setImage ("milkshake_cara.webp");
        $categorie1 -> setActive (1);

        $manager -> persist ($categorie1);
        $manager -> flush ();


        $categorie2 = new Categorie ();

        $categorie2 -> setLibelle ("Pâtisserie");
        $categorie2 -> setImage ("donut.jpg");
        $categorie2 -> setActive (1);

        $manager -> persist ($categorie2);
        $manager -> flush ();


        $categorie3 = new Categorie ();

        $categorie3 -> setLibelle ("Boissons");
        $categorie3 -> setImage ("ice-tea.jpg");
        $categorie3 -> setActive (1);

        $manager -> persist ($categorie3);
        $manager -> flush ();

        /*###############################################################
         *                       LES MILKSHAKES
        ###############################################################*/
        
        $dessert1 = new Plat ();

        $dessert1 -> setLibelle ("Milkshake chocolat");
        $dessert1 -> setDescription ("Plongez dans une expérience chocolatée exquise avec notre milkshake au chocolat, surmonté d'un biscuit croustillant. Chaque gorgée est une invitation à un voyage gustatif intense et réconfort1ant, où la douceur veloutée du chocolat rencontre la texture croquante du biscuit, pour un plaisir inégalé.");
        $dessert1 -> setPrix (4.50);
        $dessert1 -> setImage ("milk_choco.jpg");
        $dessert1 -> setActive (1);
        $dessert1 -> setCategorie ($categorie1);

        $manager -> persist ($dessert1);
        $manager -> flush ();


        $dessert2 = new Plat ();

        $dessert2 -> setLibelle ("Milkshake fraise");
        $dessert2 -> setDescription ("Savourez une explosion de fraîcheur avec notre délicieux milkshake à la fraise, orné d'une montagne de chantilly onctueuse, de morceaux de fraises juteuses et d'un coulis de fraise généreux. Chaque gorgée est une célébration de la douceur sucrée et du parfum enivrant des fraises mûres, pour une expérience gustative à la fois rafraîchissante et exquise.");
        $dessert2 -> setPrix (4.50);
        $dessert2 -> setImage ("milk_fraise.webp");
        $dessert2 -> setActive (1);
        $dessert2 -> setCategorie ($categorie1);

        $manager -> persist ($dessert2);
        $manager -> flush ();


        $dessert3 = new Plat ();

        $dessert3 -> setLibelle ("Milkshake caramel");
        $dessert3 -> setDescription ("Laissez-vous séduire par une aventure gourmande avec notre milkshake au caramel. Imaginez-vous déguster une crème glacée onctueuse au caramel, agrémentée d'une touche de chantilly aérienne, le tout entre deux cookies moelleux. Pour couronner le tout, un cône en gaufrette croustillant et des pétales d'amande viennent parfaire cette symphonie de saveurs, pour un plaisir gustatif incomparable.");
        $dessert3 -> setPrix (4.50);
        $dessert3 -> setImage ("milkshake_cara.webp");
        $dessert3 -> setActive (1);
        $dessert3 -> setCategorie ($categorie1);

        $manager -> persist ($dessert3);
        $manager -> flush ();

        /*##############################################################
         *                       LES PÂTISSERIES
        ##############################################################*/

        $dessert4 = new Plat ();

        $dessert4 -> setLibelle ("Cupcake chocolat");
        $dessert4 -> setDescription ("Plongez dans un océan de chocolat avec notre cupcake au chocolat, débordant de chocolat fondu qui s'écoule généreusement à chaque bouchée. Chaque morceau est une explosion de saveurs, avec des pépites de chocolat fondantes ajoutant une touche irrésistible à ce délice sucré, pour une expérience chocolatée intense et indulgente.");
        $dessert4 -> setPrix (3.50);
        $dessert4 -> setImage ("cupcake.jpg");
        $dessert4 -> setActive (1);
        $dessert4 -> setCategorie ($categorie2);

        $manager -> persist ($dessert4);
        $manager -> flush ();


        $dessert5 = new Plat ();

        $dessert5 -> setLibelle ("Donuts chocolat");
        $dessert5 -> setDescription ("Découvrez le plaisir simple et indulgent d'un donuts moelleux, enrobé d'un glaçage au chocolat riche et crémeux. Chaque bouchée est une rencontre avec la douceur veloutée du chocolat, offrant une expérience gourmande et réconfortante à chaque instant.");
        $dessert5 -> setPrix (3.50);
        $dessert5 -> setImage ("donut.jpg");
        $dessert5 -> setActive (1);
        $dessert5 -> setCategorie ($categorie2);

        $manager -> persist ($dessert5);
        $manager -> flush ();


        $dessert6 = new Plat ();

        $dessert6 -> setLibelle ("Pancake");
        $dessert6 -> setDescription ("Plongez dans une expérience de petit-déjeuner sensationnelle avec nos pancakes moelleux, nappés de miel doré qui s'écoule lentement. Les mûres juteuses et les framboises fraîches ajoutent une explosion de saveurs fruitées, pour un festival de douceurs matinales qui éveillent les papilles et ravissent les sens.");
        $dessert6 -> setPrix (3.50);
        $dessert6 -> setImage ("pancakes.jpg");
        $dessert6 -> setActive (1);
        $dessert6 -> setCategorie ($categorie2);

        $manager -> persist ($dessert6);
        $manager -> flush ();

        /*###############################################################
         *                         LES BOISSONS
        ###############################################################*/

        $boisson1 = new Plat ();

        $boisson1 -> setLibelle ("Café noir intense");
        $boisson1 -> setDescription ("Savourez l'élégance intemporelle d'un café noir parfaitement préparé, offrant une harmonie parfaite entre l'amertume du café et la richesse des arômes. Chaque tasse est une invitation à une pause délicieuse, offrant un moment de détente et de plaisir authentique.");
        $boisson1 -> setPrix (2.00);
        $boisson1 -> setImage ("café.jpg");
        $boisson1 -> setActive (1);
        $boisson1 -> setCategorie ($categorie3);

        $manager -> persist ($boisson1);
        $manager -> flush ();


        $boisson2 = new Plat ();

        $boisson2 -> setLibelle ("Cappuccino");
        $boisson2 -> setDescription ("Laissez-vous envoûter par la sophistication d'un cappuccino parfaitement préparé, mariant l'espresso corsé avec la douceur veloutée du lait mousseux. Chaque gorgée est une expérience sensorielle exquise, offrant une symphonie de saveurs et de textures qui séduira les amateurs de café les plus exigeants.");
        $boisson2 -> setPrix (2.00);
        $boisson2 -> setImage ("cappuccino.jpg");
        $boisson2 -> setActive (1);
        $boisson2 -> setCategorie ($categorie3);

        $manager -> persist ($boisson2);
        $manager -> flush ();


        $boisson3 = new Plat ();

        $boisson3 -> setLibelle ("Thé menthe");
        $boisson3 -> setDescription ("Détendez-vous avec notre thé à la menthe, offrant une sensation de fraîcheur pure et apaisante. Chaque gorgée est une célébration de la fraîcheur vivifiante de la menthe, offrant une expérience sensorielle apaisante et revigorante à chaque instant.");
        $boisson3 -> setPrix (2.00);
        $boisson3 -> setImage ("the.jpg");
        $boisson3 -> setActive (1);
        $boisson3 -> setCategorie ($categorie3);

        $manager -> persist ($boisson3);
        $manager -> flush ();


        $boisson4 = new Plat ();

        $boisson4 -> setLibelle ("Eau");
        $boisson4 -> setDescription ("Rafraîchissez-vous avec une eau pure et cristalline, offrant une hydratation sans pareille et une sensation de fraîcheur revigorante. Chaque gorgée est une pause bienvenue, vous permettant de savourer l'instant présent et de vous reconnecter avec la simplicité et la beauté de la nature.");
        $boisson4 -> setPrix (1.50);
        $boisson4 -> setImage ("eau.jpg");
        $boisson4 -> setActive (1);
        $boisson4 -> setCategorie ($categorie3);

        $manager -> persist ($boisson4);
        $manager -> flush ();


        $boisson5 = new Plat ();

        $boisson5 -> setLibelle ("Eau citron");
        $boisson5 -> setDescription ("Découvrez la fraîcheur revitalisante d'une eau au citron, infusée de zestes de citron pour une explosion de saveurs vives et piquantes. Chaque gorgée est une invitation à un voyage rafraîchissant et revitalisant pour les sens.");
        $boisson5 -> setPrix (1.80);
        $boisson5 -> setImage ("eau_citron.jpg");
        $boisson5 -> setActive (1);
        $boisson5 -> setCategorie ($categorie3);

        $manager -> persist ($boisson5);
        $manager -> flush ();


        $boisson6 = new Plat ();

        $boisson6 -> setLibelle ("Thé glacé");
        $boisson6 -> setDescription ("Plongez dans une oasis de fraîcheur avec notre thé glacé, offrant une fusion parfaite entre la douceur du thé infusé et la fraîcheur glacée. Chaque gorgée est une expérience rafraîchissante et revigorante, vous transportant vers des contrées lointaines et exotiques avec chaque gorgée.");
        $boisson6 -> setPrix (2.00);
        $boisson6 -> setImage ("ice-tea.jpg");
        $boisson6 -> setActive (1);
        $boisson6 -> setCategorie ($categorie3);

        $manager -> persist ($boisson6);
        $manager -> flush ();

        /*###############################################################
         *                       LES UTILISATEURS
        ###############################################################*/
        
        $user1 = new User ();
        $user1 -> setEmail ("souare@gmail.com");
        // php bin/console security:hash-password
        $user1 -> setPassword ('$2y$13$bdIhlC4/N48.mwpdWNrdXubW4iO2TjN.Bjpe38V0fSNv4fqBcVUKO');
        $user1 -> setNom ("souare");
        $user1 -> setPrenom ("ibrahima");
        $user1 -> setTelephone ("0123456789");
        $user1 -> setAdresse ("1 rue de la resistance");
        $user1 -> setCp ("60000");
        $user1 -> setVille ("beauvais");
        $user1 -> setRoles (["ROLE_CLIENT"]);

        $manager -> persist($user1);
        $manager -> flush();
        

        $user2 = new User ();
        $user2 -> setEmail ("lsf@gmail.com");
        $user2 -> setPassword ('$2y$13$4Tp70AFd.jauh2uLLvkmaui.lCDUNVI070IlKetzJcKuaffpvfZpy');
        $user2 -> setNom ("lemsatef");
        $user2 -> setPrenom ("sara");
        $user2 -> setTelephone ("0123456789");
        $user2 -> setAdresse ("2 rue de la resistance");
        $user2 -> setCp ("60000");
        $user2 -> setVille ("beauvais");
        $user2 -> setRoles (["ROLE_CLIENT"]);

        $manager -> persist($user2);
        $manager -> flush();

        /*###########################################################
         *                      LES COMMANDES
        ###########################################################*/

        $commande1 = new Commande ();
        $dateCommande1 = \DateTime::createFromFormat('Y-m-d H:i:s', '2024-07-20 06:40:21');
        $commande1 -> setDateCommande ($dateCommande1);
        $commande1 -> setTotal (9.00);
        $commande1 -> setEtat ("0");
        $commande1 -> setUser ($user1);

        $manager -> persist($commande1);
        $manager -> flush();


        $commande2 = new Commande ();
        $dateCommande2 = \DateTime::createFromFormat('Y-m-d H:i:s', '2024-06-10 07:40:21');
        $commande2 -> setDateCommande ($dateCommande2);
        $commande2 -> setTotal (14.00);
        $commande2 -> setEtat ("2");
        $commande2 -> setUser ($user1);

        $manager -> persist($commande2);
        $manager -> flush();


        $commande3 = new Commande ();
        $dateCommande3 = \DateTime::createFromFormat('Y-m-d H:i:s', '2024-09-24 19:40:21');
        $commande3 -> setDateCommande ($dateCommande3);
        $commande3 -> setTotal (9.00);
        $commande3 -> setEtat ("3");
        $commande3 -> setUser ($user2);

        $manager -> persist($commande3);
        $manager -> flush();

    }
}
