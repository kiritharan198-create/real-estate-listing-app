DAY 1 – Real Estate Listing App (ikman.lk style)
--------------------------------------------------
What you have here:
- index.html: Home page with hero + demo search + sample cards
- form.html: Add Property form + client-side validation (Day 1 demo only)
- about.html: Project info and week plan
- contact.html: Contact form + client-side validation
- test.html: For XAMPP setup verification
- assets/css/styles.css, assets/js/main.js

How to run (XAMPP):
1) Start Apache and MySQL in XAMPP.
2) Copy the folder 'real-estate-listing-app' into C:\xampp\htdocs
3) Open your browser to: http://localhost/real-estate-listing-app/test.html  (should say "Hello Intern!").
4) Then open: http://localhost/real-estate-listing-app/index.html

Git tips:
  git init
  git add .
  git commit -m "Day 1 - Setup + Bootstrap pages + JS validation"
  git branch -M main
  git remote add origin https://github.com/YOUR-USERNAME/real-estate-listing-app.git
  git push -u origin main

Next days:
- Create MySQL DB + 'properties' table and convert forms to PHP (insert/read).
- Build listing grid from DB + add filters.
