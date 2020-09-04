<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SmsTrimis;

class SmsTrimiteController extends Controller
{
    public function trimite_sms($categorie = null, $subcategorie = null, $inregistrare_id = null, $telefon = null, $mesaj = null)
    {       
        // dd($inregistrare_id, $categorie, $subcategorie, $telefon, $mesaj);
        // Setare variabila test pentru ANDREI DIMA TESTȘ
        // if (($rezervare->nume == "ANDREI DIMA TESTȘ") || ($rezervare->nume == "ANDREI DIMA TESTș")){
        //     $test = 1; // sms-ul nu se trimite
        // } else {
        //     $test = 0; // sms-ul se trimite
        // }

        $test = 1; // sms-ul nu se trimite
        // $test = 0; // sms-ul se trimite        

        // ----------------------------------------------------------------------------
        // 
        //    Exemplu minimal pentru trimiterea de SMS-uri (PHP)
        //    Serviciul SMS Gateway
        //    Versiunea 1.1 / 12.04.2010
        //    Distribuit gratuit    
        //
        // ----------------------------------------------------------------------------

        // ----------------------------------------------------------------------------
        //  Pasul 1    
        //  Interogam SMS Gateway si salvam rezultatul trimis de acesta in variabila 
        //  pentru a putea interpreta statutul trimiterii
        //   - Pentru HTTPS utilizati https://secure.smslink.ro
        // ----------------------------------------------------------------------------
        $content = file_get_contents("http://www.smslink.ro/sms/gateway/communicate/?" .
            "connection_id=" . config('sms_link.connection_id') . "&password=" . config('sms_link.password') .
            "&to=" . $telefon . "&message=" .
            // urlencode("Salut " . $rezervari->nume) .
            urlencode($mesaj) .
            '&test=' . $test);
        // dd($content);
        // ----------------------------------------------------------------------------
        //  Pasul 2
        //  Interpretam rezultatul pentru a avea acces la tot continutul acestuia si
        //  a putea intelege rezultatul mesajului trimis spre SMS Gateway
        //
        //  Rezultatul transmis de SMS Gateway va fi intotdeauna de forma urmatoare:
        //  string Nivel;int ID Rezultat;string Mesaj;string[optional] Variabile
        // ----------------------------------------------------------------------------
        //  Pasul 2.1
        //  Extragem din rezultat toate variabilele separate prin punct si virgula 
        // ----------------------------------------------------------------------------
        list($level, $id, $response, $variabiles) = explode(";", $content . ';');

        // ----------------------------------------------------------------------------
        //  Pasul 2.2
        //  Verificam daca mesajul trimis a fost transmis cu succes prin compararea
        //  Nivelului si ID Rezultat
        // ----------------------------------------------------------------------------
        //  Daca mesajul este transmis atunci Nivelul va fi MESSAGE si ID- rezultat 
        //  va avea valoarea numerica 1    
        // ----------------------------------------------------------------------------
        if (($level == "MESSAGE") and ($id == 1)) {
            // ------------------------------------------------------------------------    
            //  Variabilele optionale transmise optional sunt separate prin virgula
            //  si vor avea forma urmatoare:
            //  mixed Variabila 1,mixed Variabila 2 ... mixed Variabila 3                
            // ------------------------------------------------------------------------
            $variabiles = explode(",", $variabiles);

            // ------------------------------------------------------------------------
            //  Extragem ID-ul Mesajului alocat de gateway pentru a il salva pentru
            //  utilizare ulterioara. Message ID  va fi intotdeauna prima variabila 
            //  trimisa, restul fiind explicate complet in documentatia de pe site. 
            // ------------------------------------------------------------------------
            $message_id = $variabiles[0];

            // ------------------------------------------------------------------------
            //  Pasul 3
            //  Afisam mesajul de confirmare si afisam Message ID-ul alocat
            // ------------------------------------------------------------------------
            // echo "Mesajul a fost trimis si are ID-ul " . $message_id . "!";

            $smsTrimis = new SmsTrimis;
            $smsTrimis->inregistrare_id = $inregistrare_id;
            $smsTrimis->categorie = $categorie;
            $smsTrimis->subcategorie = $subcategorie;
            $smsTrimis->telefon = $telefon;
            $smsTrimis->mesaj = $mesaj;
            $smsTrimis->trimis = 1;
            $smsTrimis->mesaj_id = $message_id;
            $smsTrimis->raspuns = $response;
            $smsTrimis->content = $content;
            $smsTrimis->save();
            // return redirect('/clienti')->with('status', 'SMS-ul către "' . $clienti->nume . '" a fost trimis cu succes și are ID-ul ' . $message_id . "!");
            // return redirect('/clienti')->with('status', 'SMS-ul către "' . $clienti->nume . '" a fost trimis cu succes!');
            // $raspuns['sms-trimis'] = $smsTrimis;
            // return ($raspuns);
            
            return back()->with('status', 'SMS-ul către numărul de telefon ' . $telefon . ' a fost trimis cu succes!');

        } else {
            if ($level == "ERROR") {
                // --------------------------------------------------------------------
                //  Pasul 3
                //  Afisam mesajul de eroare si afisam ID-ul erorii si descrierea
                // --------------------------------------------------------------------
                // echo "A intervenit eroarea ID " . $id . ", Descriere " . $response;

                $smsTrimis = new SmsTrimis;
                $smsTrimis->inregistrare_id = $inregistrare_id;
                $smsTrimis->categorie = $categorie;
                $smsTrimis->subcategorie = $subcategorie;
                $smsTrimis->telefon = $telefon;
                $smsTrimis->mesaj = $mesaj;
                $smsTrimis->trimis = 0;
                $smsTrimis->raspuns = $response;
                $smsTrimis->content = $content;
                $smsTrimis->save();

                // return redirect('/clienti')->with('status', "A intervenit eroarea ID " . $id . ", Descriere: " . $response);
                // $raspuns = array();
                // array_push($raspuns, $smsTrimis);
                // array_push($raspuns, $response);
                // $raspuns = [];
                // $raspuns['sms-trimis'] = $smsTrimis;
                // $raspuns['id'] = $id;
                // $raspuns['raspuns'] = $response;
                // return ($raspuns);
                return back()->with('error', 'SMS-ul nu a fost trimis! A intervenit următoarea eroare: ' . $response);
            }
        }
    }
}
