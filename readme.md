# Dokumentace

## Spuštění
Projekt spustíte pomocí příkazu:
    ```
    docker-compose up -d
    ```

## Struktura aplikace
Aplikace je rozdělena na několik částí:
1. app/ - složka obsahující hlavní soubory aplikace (kontrolery, modely, pohledy a další potřebné třídy).
2. config/ - obsahuje konfigurační souboty Dockeru.
3. vendor/ - složka knihoven.
4. www/ - obsah webu (css, Javascriptové soubory, fonty).
5. zeta/ - složka s cache a soubory s chybovými hlášeními.

## Kontrolery
Po spuštění webu ja dotaz směřován na příslušný kontroler.
- API: Na požádání vrací data z databáze.
- Download: Řeší formulář pro stažení dat do databáze.
- Tabulka: Vykrasluje hlavní stránku.

## Funkcionalita
Aplikace splňuje následující požadavky:
- **Přenést data** – stažení dat ze vzdáleného zdroje do výstupu dat,
- **Zobrazit data** – strukturované zobrazení stažených záznamů, chronologicky seřazené,
- **Označit data** – možnost podbarvit libovolné záznamy.

Poznámka: Záznamy je možné označovat i z klávesnice s odečítačem obrazovky (pomocí enteru nebo mezerníku).