<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'semanticblog');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '2ww:_+{.:}kQ0`)<*V!WSJ+[Wwt*pccU[wOq(r|UAP4q$^@3%hFs8<;h 4$~,xs;');
define('SECURE_AUTH_KEY',  'ehR.;S6F-pZpGaHOAE>?{:Yp@2WA:{ D^<q)](@Q(hNqa(~kIr,w#.3tU.}0R~(e');
define('LOGGED_IN_KEY',    '*eZ*#jJdX0u_5lUZhoHfS#yT*6KUFxY++#P7,TU|T3A?wxA(+%O+Ia%&=AFKCW3e');
define('NONCE_KEY',        'Vd8Ttegcxfz9&xS|~P[^swJQuAlU=GmgJZ#{.i.}~ik61vZgaTeyH>i(Z2Ey-|10');
define('AUTH_SALT',        '2#_}V$do3[BTxc~FV3oDm8VSQ03be0hV|Z 2Xm]~|D7d~S&ArAl;P41iP$(?Atae');
define('SECURE_AUTH_SALT', 'E+i}t=>CT~eKS$.~0M+@2DZFeMU~o8_[&j{)2Q/OEJr$n=W7^OCcFz |*vdD-GSB');
define('LOGGED_IN_SALT',   'mcL_ 24$[DC)!k]o,>C-B6l!QrgKmg>#~<sOmug?r=3JGQ$PNa/_Qj]9g*cjtU@v');
define('NONCE_SALT',       ' 0G7~0c2k1tEdwET?jH#`C1pfN>+ p/*=.9kI/n1|k*z1{AGiPx+G2uX&q$7vI>,');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');

