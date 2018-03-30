# Sociální síť
domácí úkol z předmětu **vývoj webových aplikací**
## Odevzdání
**Datum odevzdání je: 30. 5. 2018**<br>
Celý postup vývoje zaznamenávejte pomocí systému **git**.
To bude i vaší výslednou prácí, která bude hodnocena.<br>
**Nezapomeňte do repozitáře přidat i dump vaší databáze!**<br>
Můžete si vybrat z několika volně dostupných poskytovatelů:<br>
- GitHub - zdarma pouze veřejné repozitáře (https://github.com)
- BitBucket - zdarma (https://bitbucket.org)
- GitLab - zdarma (https://gitlab.com)

Následně nahrávejte změny (commity) pomocí jednoho z mnoha nástrojů.<br>
Můžete si vybrat zde:<br>
https://git-scm.com/downloads/guis/<br>
nebo využijte aplikace v textovém prostředí:<br>
https://git-scm.com/downloads<br><br>

Jak se se systémem Git pracuje se můžete naučit zde:
https://git-scm.com/doc

## Zadání
Z přiložené ho projektu vytvořte plně funkční sociální síť.<br>
V kořenu repozitáře vytvořte soubor README.md s popisem postupu nasazení vaší aplikace.
- Uživatelé
    - Systém přátelství (hotovo)
    - Stránky profilů (hotovo)
        - Úprava profilu (hotovo)
        - Nahrávání headeru (hotovo)
        - Nahrávání profilového obrázku (hotovo)
        - Počet přátel (hotovo)
    - Společné skupiny (jako ta naše na FB)
    - Registrace (hotovo)
    - Přihlášení (hotovo*)
        - *Nefunkční ověření hesla
    - Vyhledávání uživatelů (hotovo)
    
- Feed / Nejnovější příspěvky uživatelů (známe z facebooku)
    - Příspěvky (hotovo)
    - Hodnocení (like) (hotovo)
    - Sdílení
    - Sdílení obrázků
    - Sdílení youtube videí
    - Čas přidání příspěvku (hotovo)
    - Mazání příspěvků (hotovo)
    - Nahrávání příspěvků přes ajax
    
## Popis postupu práce
Nejdřív jsem se pokoušel upravit to, co jsem forknul. Nebyl jsem vůbec schopnej to rozchodit, 
a tak jsem stáhnul čistý Nette a Bootstrap a přepsal jsem tim ty soubory. 
Přihlášení a registraci jsem použil z mýho celoročního projektu a lehce upravil. 
Nemám nejmenšího šajna, proč mi to při přihlášení házelo výjimku špatné heslo. 
Je to úplně stejný, jako v mym projektu... Tak jsem tu sekci kontroly hesla vykomentoval. 
(Jo, vim že je to docela velkej problém, ale sry, už jsem na to fakt neměl..) 
S vyhledávánim uživatelů jsem měl trochu problém, aby se neopakovali. 
Vyřešil jsem to rozdělenim do sekcí podle jména, příjmení a emailu. 
Přidávání a odstraňování příspěvků mám taky z mýho projektu a úprava profilu 
(i s nahrávánim obrázků) je na tom podobně. Na liky jsem si udělal tabulku, kam si ukládám, 
kdo a co liknul. Podobně mám udělanou i tabulku na přátele. Do ní si ukládám id uživatele a id přítele, 
z toho pak tahám všechno potřebný. Co se týče sdílení, tak nemám vůbec tušení, jak to udělat. 
Něco jsem zkoušel, ale moc to nefungovalo. 
A jak udělat rozumný sdílení už předtim sdílenýho příspěvku mě taky nenapadlo. 
Co se týče ajaxu, tak ten jsem z dokumentace Nette nepochopil a na skupině to zavěšený neni, 
takže to taky nemám.<br>
Závěrem.. No, něco jsem udělal, nějak to funguje.. Na nějakou stilizaci stránky mi nezbyl čas, 
jelikož jsem ho strávil dost v backgroundu řešenim problémů, který jsem z většiny stejně nevyřešil. 
A tak to vypadá, jak to vypadá..