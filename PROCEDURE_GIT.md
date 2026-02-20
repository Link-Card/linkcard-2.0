# PROCÉDURE GIT — LINKCARD 2.0

## ⚠️ RÈGLE #1 : TOUJOURS TRAVAILLER SUR LA BRANCHE `main`
La branche de production est **main** (PAS master).

---

## 🔧 SETUP CLAUDE (début de chaque conversation)

```bash
git config --global http.proxyAuthMethod basic
git config --global http.proxy "$HTTPS_PROXY"
git config --global user.email "linkcard@linkcard.ca"
git config --global user.name "Link-Card"
git clone -b main https://Link-Card:TOKEN@github.com/Link-Card/linkcard-2.0.git /home/claude/linkcard-2.0
# Le TOKEN est dans les instructions projet Claude (project files)
```

**VÉRIFICATION OBLIGATOIRE après clone:**
```bash
cd /home/claude/linkcard-2.0
git branch  # DOIT afficher "* main"
```

---

## 📤 WORKFLOW: Claude → Serveur

### 1. Claude fait les modifications
```bash
cd /home/claude/linkcard-2.0
# ... modifications ...
git add -A
git commit -m "Description claire"
git push origin main
```

### 2. User déploie sur le serveur
```bash
cd /var/www/app.linkcard.ca
git pull origin main
```

### 3. Si migration nécessaire
```bash
php artisan migrate --force
```

### 4. Vider les caches
```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### 5. Si vim s'ouvre (message de merge)
Appuyer sur **Échap**, taper `:wq`, appuyer sur **Entrée**.

---

## 🚨 EN CAS DE CONFLIT GIT

### Option A: Forcer la version GitHub (si Claude vient de push)
```bash
git reset --hard origin/main
git pull origin main
```

### Option B: Forcer la version serveur (si serveur a la bonne version)
```bash
git add -A
git commit -m "État actuel serveur"
git push origin main --force
```

---

## 🔄 EN CAS DE PROBLÈME GRAVE

### Restaurer via DigitalOcean Snapshot ou Git:
1. DigitalOcean → Droplet → Snapshots → Restaurer
2. Ou `git log --oneline -10` pour trouver le dernier commit fonctionnel
3. `git revert HEAD` ou `git reset --hard <commit>`
4. Après restauration:
```bash
cd /var/www/app.linkcard.ca
git add -A
git commit -m "Restore backup [date]"
git push origin main --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
chown -R www-data:www-data /var/www/app.linkcard.ca
```

---

## ❌ NE JAMAIS FAIRE
- Travailler sur une branche autre que `main`
- `git reset --hard` sans vérifier qu'on a une backup
- Modifier des fichiers directement sur le serveur sans commiter
- Utiliser `origin/master` au lieu de `origin/main`
