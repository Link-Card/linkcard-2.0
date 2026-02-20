# LINKCARD — MAINTENANCE PÉRIODIQUE

## Nettoyage fichiers temporaires

### Livewire uploads temporaires
Les fichiers uploadés via Livewire sont stockés temporairement avant traitement.
Ils s'accumulent avec le temps (surtout les carrousels : 7+ images × 15MB).

```bash
rm -rf /var/www/app.linkcard.ca/storage/app/private/livewire-tmp/*
```

### Carousel staging orphelins
Si un upload carrousel échoue ou est annulé, des fichiers peuvent rester en staging.

```bash
rm -rf /var/www/app.linkcard.ca/storage/app/public/carousel-staging/
```

### Fréquence recommandée
- **Hebdomadaire** en développement/beta
- **Mensuelle** en production (ou via cron)

### Cron automatique (optionnel)
Ajouter dans crontab (`crontab -e`) — hebdomadaire :
```bash
0 3 * * 0 find /var/www/app.linkcard.ca/storage/app/private/livewire-tmp -type f -mtime +1 -delete 2>/dev/null
0 3 * * 0 find /var/www/app.linkcard.ca/storage/app/public/carousel-staging -type f -mtime +1 -delete 2>/dev/null
```
