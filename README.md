Vizinhocas
==========

Site da Coolmeia para compartilhamento e trocas de bens, serviços, conhecimento, habilidades e tempo.


```
<VirtualHost *:80>
    ServerName vizinhocas.local
    DocumentRoot /var/www/vizinhocas/public
    <Directory /var/www/vizinhocas/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
 </VirtualHost>
``` 

