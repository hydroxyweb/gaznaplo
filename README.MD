## 🌿 Project Overview

A **Gáznapló** projekt célja, hogy átlátható módon segítse a háztartási gázfogyasztás nyomon követését.
Az alkalmazás lehetővé teszi, hogy minden hónapban rögzítsd a gázmérő állását, majd ezek alapján automatikusan kiszámolja:

* a tényleges fogyasztást,
* az adott hónap **jelleggörbéjéhez** viszonyított eltérést,
* valamint a **kedvezményes mennyiséghez** képest mutatkozó túlfogyasztást vagy megtakarítást.

A cél, hogy egyértelmű visszajelzést adjon (pl. színekkel, ikonokkal vagy statisztikákkal), mennyire jól alakul a fogyasztás az adott időszakban — így időben felismerhetők az esetleges túlhasználatok vagy megtakarítási lehetőségek.

---

## ⚙️ Tech Stack

- **Backend:** Leaf MVC v4 (Leaf v4)  
- **Frontend:** Vue 3 + Typescript 
- **Styling:** TailwindCSS  
- **Language:** PHP 7.4+  
- **Package manager:** Composer & npm 

---

## 🚀 Telepítés és futtatás

1. **Projekt klónozása**

   ```bash
   git clone https://github.com/hydroxyweb/gaznaplo.git
   cd gaznaplo
   ```

2. **Függőségek telepítése**

   ```bash
   composer install
   npm install
   ```

3. **Környezeti beállítás**
   Másold le a `.env.example` fájlt `.env` néven, majd állítsd be az adatbázis kapcsolatot:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=adatbazis_nev
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Adatbázis migrációk futtatása**

   ```bash
   php leaf db:migrate
   ```

5. **Fejlesztői szerver indítása**

   ```bash
   php leaf serve
   VAGY
   php -S localhost:8000 -t public
   ```


---

## 🧠 Hasznos parancsok

| Parancs               | Leírás                     |
| --------------------- | -------------------------- |
| `php leaf db:migrate` | Migrációk futtatása        |
| `php leaf serve`      | Beépített szerver indítása |
| `php leaf db:seed`    | Tesztadatok betöltése      |
| `composer update`     | Függőségek frissítése      |
| `npm run dev`         | Frontend fejlesztői szerver indítása (Vite) – automatikus újratöltéssel      |
| `npm run build`         | Frontend buildelése éles környezethez      |
---

## 📦 Deployment

A telepítésről és szerverre való feltöltésről további részleteket találsz a [Leaf dokumentációban](https://leafphp.dev/learn/deployment/).

---

## 📜 Licenc

Ez a projekt az MIT License alatt érhető el.
Szabadon használható, másolható, módosítható és terjeszthető, mindaddig, amíg az eredeti licenc és szerzői jogi nyilatkozat megmarad a forrásban.
