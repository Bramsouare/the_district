$(document) . ready (function () 
{

    $("#envoyer") . click (function (e) 

        {
            validation(e);
        }
    );

    function validation (e) 
    {
       
        var envoi = true;

        var nom = $("#nom") . val ();
        if (nom === "") 
        {
            envoi = false;
            $("#n") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#n") . hide ();
        };
     
        var prenom = $("#prenom") . val ();
        if (prenom === "") 
        {
            envoi = false;
            $("#p") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#p") . hide ();
        };


        var email = $("#email") . val ();
        if (email === "") 
        {
            envoi = false;
            $("#e") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#e") . hide ();

        };


        var telephone = $("#telephone") . val ();
        if (telephone === "") 
        {
            envoi = false;
            $("#t") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#t") . hide ();
        };


        var message = $("#message") . val ();
        if (message === "") 
        {
            envoi = false;
            $("#m") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#m") . hide ();
        };
       
    };

    $("#envoie") . click (function (e) 

        {
            valide (e);
        }
    );

    function valide(e) 
    {

        var nomp = $("#nomPrenom") . val ();

        if (nomp === "") 
        {
            envoi = false;
            $("#n_manquant") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#n_manquant") . hide ();
        }

        var emails = $("#emails") . val ();
        if (emails === "") 
        {
            envoi = false;
            $("#email_manquant") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#email_manquant") . hide ();
        }

        var tel = $("#telephones") . val ();
        if (tel === "") 
        {
            envoi = false;
            $("#telephone_manquant") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#telephone_manquant") . hide ();
        }

        var adresses = $("#adresses") . val ();
        if (adresses === "") 
        {
            envoi = false;
            $("#adresse_manquant") . show ();
            e . preventDefault ();
        }
        else 
        {
            $("#adresse_manquant") . hide ();
        }

    };

    var btns = $("#btns");

    var result = $("#a"); // la div des cartes de l'index

    var index = $(".index"); // la div de lindex

    var form = $(".form"); // la div du formulaire

    var commande = $("#commande"); // la div commande

    var divplat = $('#divplat'); // la ou sa sera afficher

    var divcat = $('#divcat'); // l'endroit de l'affichage

    var smplat = $(".smplat"); // la div de laffichage de carte

    var visuel = $("#visuel")

    index.show(); // afficher l'index

    form.hide(); // masquer le formulaire

    $.getJSON('asset/json/json.json', function(data) // recupère les données json
    { 

        // extrait de json les élémens categorie et plat
        var categorie = data.categorie;
        var plat = data.plat;


// BARRE DE RECHERCHE :


        // (cc) cliquer sur le bouton chercher
        $("#cc") . click (function () 

            {
                chercher();
            }
        );

        function chercher () 
        { 

            visuel . hide (); // masquer la page
            index . hide (); // masquer l'index
            result . empty (); // vider le resultat
            smplat . empty (); // vider l'affichage de ses carte
            divcat . empty (); // vider l'affichage de ses carte

            var input = $("#input") . val (); // recupère la valeur du champs

            var matchPlats = plat . filter (function (pla) // filtre les plats avec libelle

                { 

                    // rendre le code insensible aux majuscules et minuscules 
                    return pla . libelle . toLowerCase () . includes (input . toLowerCase ());

                }
            );

            $. each (matchPlats, function (element, item)  // parcourir chaque plat filtrer

                {

                    // crée une carte pour chaque éléments qui s'affiche quand on click go!
                    var carte = ` 
                        <div class="card custom-border bg border zoom col-2 mb-3 my-4 mx-4 d-flex justify-content-center">
                            <img src="images_the_district/${item.image}" class="card-img-top border-1 mt-3 img-fluid cards-img timg" alt="${item.libelle}">
                            <div class="card-body text-center">
                                <h2 class="card-title">${item.libelle}</h2>
                                <p class="card-text text-center">${item.description} <br>
                                Menu: ${item.prix} €</p>
                                <a href="index.php?page=commande&id=${item.id_plat}" value="${item.id_plat}" class="btn btn-light d-flex justify-content-center idd">Commander</a>
                            </div>
                        </div>`;

                    // ajoute la carte a la liste des resultats de recherche
                    smplat . append (carte);

                }
            );

        };


// CLICK CARTE CATEGORIE :


        $(".ck") . click (function () // quand l'élément ck est cliqué 
        { 

            visuel . hide (); // masquer l'index

            // trouvé la valeur sur l'élément cliqué puis l'affecte dans la variable 
            var platid = $(this) . find (".gg") . attr ("data-id");

            // vider le resultat de la recherche
            result . empty ();

            // parcour chaque élément dans le tableau plat
            $. each (plat, function (index, un) 
            {

                // récupère l'id de la catégorie de l'élément 
                var catid = un . id_categorie;

                // vérifie si l'id de la catégorie et l'id en cours de traitement correspondent
                if (catid == platid) 
                {

                    // crée une carte carte qui s'affiche quand on click sur une carte de l'index
                    var card = `
                        <div class="card custom-border bg zoom col-12 col-md-2 mb-3 my-3 mx-4 d-flex justify-content-center">
                            <img src="images_the_district/${un.image}" class="card-img-top border-1 mt-3 img-fluid card-img timg" alt="${un.libelle}">
                            <div class="card-body text-center">
                                <h2 class="card-title">${un.libelle}</h2>
                                <p class="card-text">${un.description} <br>
                                Menu: ${un.prix} €</p>
                                <a type="submit" href="index.php?page=commande&id=${un.id_plat}" value="${un.id_plat}" class="btn btn-light d-flex justify-content-center idd">Commander</a>
                            </div>
                        </div>`;

                    // afficher les carte de resultat    
                    result . append (card);

                };

            });

        });


        // AFFICHAGE CARTE CATEGORIES :


        // for (i = 0; i < categorie.length; i++) { // boucle qui parcour la longeur de categorie dans json 

        //     var cat = categorie[i]; // et mis a jour pour crée dynamiquement les carte

        //     // carte qui s'affiche sur l'index 
        //     var card = $( `
        //         <div class="card custom-border bg zoom ck col-12 col-md-2 bg my-4 mx-5 " >
        //             <img src="asset/images_the_district/categorie/${cat.image}" class="card-img-top border-1 mt-3 img-fluid cards-img imgs" alt="${cat.libelle}">
        //             <div class="card-body text-center">
        //                 <h2 value="${cat.id_categorie}"class="card-text text-wrap">${cat.libelle}</h2>
        //                 <span class="alert text-danger"></span>
        //             </div>
        //         </div>`);

        //     var alert = card.find(".alert");
        //         alert.text(cat.active === 'Yes' ? '' : 'victime de son succès');

        //     if (cat.active === "Yes") { 
        //         divcat.append(card); // afficher les carte de divcat
        //     }

        //     else {

        //         // carte qui s'affiche avec le message d'alert
        //         vide = $( `
        //             <div class="card custom-border bg zoom  col-12 col-md-2 bg my-4 mx-5 " >
        //                 <img src="asset/images_the_district/categorie/${cat.image}" class="card-img-top border-1 mt-3 img-fluid cards-img imgs" alt="${cat.libelle}">
        //                 <div class="card-body text-center">
        //                 <h2 value="${cat.id_categorie}"class="card-text text-wrap">${cat.libelle}</h2>
        //                 <span class="alert text-danger"></span>
        //             </div>
        //         </div>`);

        //         divcat.append(vide); // afficher les carte de divcat

        //         var alert = vide.find(".alert");
        //         alert.text(cat.active === 'Yes' ? '' : 'victime de son succès');
        //     };


        // };


        // CLICK COMMANDE :


        // $(document).on("click", ".idd", function(e) { // evenement clic sur le document 

        //     e.preventDefault(); // evite que le document soit charger quand un lien et cliqué

        //     var ids = $(this).attr("value"); // récupère la valeur de l'élément cliqué

        //     pushcommande(ids); // appele la fonction avec la valeur de l'élément

        // });

        // function pushcommande(ids) { // déclare la fonction avec un paramètre ids


        //     divplat.empty(); // cache les carte de plats
        //     result.empty(); // vide les contenue des variables
        //     smplat.empty(); 
        //     form.show(); // affiche le formulaire

        //     console.log(ids);
        //     $.each(plat, function(groupe, individuel){ // parcour chaque élément de json 

        //         if (ids == individuel.id_plat){ // compare si l'id et comparable a l'id plat

        //             // création de ou des la cartes
        //             var carte = ` 
        //                 <div class="card custom-border bg zoom col-12 col-md-2 mb-3 my-3 mx-4 d-flex justify-content-center">
        //                     <img src="asset/images_the_district/food/${individuel.image}" class="card-img-top border-1 mt-3 img-fluid card-img imgs" alt="${individuel.libelle}">
        //                     <div class="card-body text-center">
        //                         <h2 class="card-title">${individuel.libelle}</h2>
        //                         <p class="card-text">${individuel.description} <br>
        //                         Menu: ${individuel.prix} €</p>
        //                         <a href="#" class="btn btn-light d-flex justify-content-center">Quantité: 1</a>
        //                     </div>
        //                 </div>`;
        //             commande.append(carte); // affiche les cartes


        //         };
        //     });
        // };


        // AFFICHAGE CARTE PLATS :


        // for (i = 0; i < plat.length; i++) { // une boucle qui parcour tout les plats

        //     var plt = plat[i]; // mis a jour pour crée dynamiquement les cartes

        //     // carte qui s'affiche sur la page
        //     var card = `
        //     <div class="card custom-border bg zoom col-12 col-md-2 mb-2 my-2 mx-3">
        //         <img src="asset/images_the_district/food/${plt.image}" class="card-img-top border-1 mt-3 img-fluid card-img timg" alt="${plt.libelle}">
        //         <div class="card-body text-center">
        //             <h3 class="card-title">${plt.libelle}</h3>
        //             <p class="card-text">${plt.description} <br>
        //             Menu: ${plt.prix} €</p>
        //             <a href="#" value="${plt.id_plat}" class="btn btn-light
        //             d-flex justify-content-center idd">Commander</a>
        //         </div>
        //     </div></div>`;
        //     divplat.append(card);
        // };

    });

});