<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'avfkzfxroot' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'avfkzfxroot' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'e3vZyKR9JKJd' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'avfkzfxroot.mysql.db' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'u~q:)Ajn,y>&|<TJdouLXTw~U>T0h^@E-WBlTF^cXBvN =A){<hGoWtd[zVf#b, ' );
define( 'SECURE_AUTH_KEY',  '>)W0MRJ/ ks,U~h@duCcJ@haxH=RTf0mG|67!/^-aV^<{YYl9JQreddCe[j.^a9D' );
define( 'LOGGED_IN_KEY',    '$P<+4J/r>g>SF-+Ao*a->3i]D@~AE:_@uMua]UVrBasGxgy< 1~t/ZY{@yU/)Nh5' );
define( 'NONCE_KEY',        '#2iJI2G9r~M5$JU,X#B5|:E;_>TQ<d-DqT1k(@5I>y,rV.)pMOMB26pHJK*1jk:&' );
define( 'AUTH_SALT',        ' cTgYEt]0= mb*SEv0 K)@S(Uddl:qxW9x<ba3_KSL|t{}dq^bj`]*U7eRVJ &Q7' );
define( 'SECURE_AUTH_SALT', 'GwiIDd%E^?`lDasi(iO84dd1{L%3Ec&7@l@M$:,fd[m>K!SCEnfZ&VV01-U2w#qn' );
define( 'LOGGED_IN_SALT',   'v:dAiWR_8z7fuUhpq85g49^>A)?;~udZ:J@8G{)`p:E6Vlj>KEdVgLh$F>fY=$G2' );
define( 'NONCE_SALT',       '1d$}~BRhsddGgp8W$/4iV<tIpy4j?ED2S=}:F+0LMi^>7ini_4|F<baOArZn*7va' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
