<?php

namespace Pterodactyl\Console\Commands;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BillingModule extends Command
{

  protected $signature = 'billing:install {ver=stable} {lic_key?} {ver_num=latest}';
  protected $description = 'Installs the Billing Module for Pterodactyl';
  private $install = [];

  public function __construct()
  {
    parent::__construct();
    $this->app = parse_url(config('app.url'))['host'];
    $this->url = 'https://vertisanpro.com/api/license';
  }

  public function handle()
  {
    $this->prepareArgs($this->arguments());
    switch ($this->argument('ver')) {
      case 'help':
        $this->help();
        break;
      case 'uninstall':
        $this->uninstall();
        break;
      default:
        $this->install();
        break;
    }
  }

  private function install()
  {
    
    $this->infoNewLine("
       ======================================
       |||  Billing Module Installer      |||
       |||          By DzHostingID  |||
       ======================================");

    $this->SshUser();
    
    if (!isset($this->install['lic_key'])) {
      $lic_key = $this->ask("Please enter a license key. Enter cum69420 to pass license check! Do not have a purchase license at wa.me/6288232154376");
      $this->install['lic_key'] = $lic_key;
    }

    $this->infoNewLine("Your license key is: {$this->install['lic_key']}");

    if ($this->install['lic_key'] == "dzhostingid") {

      $this->setApp();

      $this->infoNewLine("
      =+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+
        Thank you for \"purchasing\" the Billing Module
        Automatic Installation Started, This can take a few minutes!.
      =+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+"
      );

      $this->infoNewLine("Run Migrate");
      $this->shell('php artisan migrate --force --path=/database/migrations/billing');
      $this->infoNewLine("Install Stripe SDK");
      $this->shell('echo \"yes\" | composer require stripe/stripe-php');
      $this->infoNewLine("Install CloudFlare SDK");
      $this->shell('echo \"yes\" | composer require cloudflare/sdk');

      $this->installSocialite();

      $this->infoNewLine("Compiling Panel Assets (This can take a minute, please wait...)");
      $this->shell('yarn && yarn build:production');

      $this->infoNewLine("Ensuring correct file permissions are set & Updating dependencies");
      $this->shell('chmod -R 755 storage/* bootstrap/cache');
      $this->shell('echo \"yes\" | composer install --no-dev --optimize-autoloader');
      $this->shell('chown -R www-data:www-data '.base_path().'/*');
      $this->shell('php artisan queue:restart');
      $this->shell('php artisan view:clear && php artisan config:clear');

      $this->infoNewLine("
        ==========================================================================
                Installation Complete! Successfully installed Billing By DzHostingID v6.9.420
        ==========================================================================");
      DB::table('billing_settings')->updateOrInsert(['name' => 'license_key'], ['data' => $this->install['lic_key']]);
    } else {
      $this->error("Anda telah memasukkan kunci lisensi yang tidak valid!");
    }
  }

  private function reqOut($req, $success = true)
  {
    if (!$req->resp) {
      $this->newLine();
      $this->error($req->text);
      exit;
    } else {
      if ($success) {
        $this->infoNewLine($req->text);
      }
    }
  }

  private function shell($cmd)
  {
    return exec($cmd);
  }

  private function req($url)
  {
    return Http::get($url)->object();
  }

  private function prepare($args)
  {
    foreach ($args as $key => $arg) {
      $this->install[$key] = $this->shell($arg);
    }
    $this->install['url'] = "{$this->url}/{$this->install['lic_key']}/{$this->install['arg1']}/{$this->app}/{$this->install['ver']}/{$this->install['ver_num']}";
  }

  private function prepareArgs($arguments)
  {
    foreach ($arguments as $key => $val) {
      $this->install[$key] = $val;
    }
    unset($this->install['command']);
  }

  private function help()
  {
    $help = '
      Help:
      php artisan billing:install installer - updating the command to automatically install the module (recommended to run before each installation/update of the module)
      php artisan billing:install stable {license key}(optional) - install stable version
      php artisan billing:install dev {license key}(optional) - install dev version(no recommend!!!)
      ';
    return $this->infoNewLine($help);
  }

  private function update()
  {
    $key = \Pterodactyl\Models\Billing\Bill::settings()->getParam('license_key');
    $this->shell("cd ".base_path()." | php artisan billing:install stable {$key}");
  }

  private function infoNewLine($text)
  {
    $this->newLine();
    $this->info($text);
    $this->newLine();
  }

  private function SshUser()
  {
    $SshUser = $this->shell('whoami');
    if(isset($SshUser) AND $SshUser !== "root") {
      $this->error('
      We have detected that you are not logged in as a root user.
      To run the auto-installer, it is recommended to login as root user.
      If you are not logged in as root, some processes may fail to setup
      To login as root SSH user, please type the following command: sudo su
      and proceed to re-run the installer.
      alternatively you can contact your provider for ROOT user login for your machine.
      ');

      if($this->confirm('Stop the installer?', true)) {
        $this->info('Installer has been cancelled.');
        exit;
      }
    }
  }

  private function setApp()
  {
    $alias1 = '\'Theme\' => Pterodactyl\Extensions\Facades\Theme::class,';
    $alias2 = '        \'Bill\' => Pterodactyl\Models\Billing\Bill::class,';
    $file = config_path() . '/app.php';

    $app_file = require($file);

    if (isset($data['aliases']['Bill'])) {
      return;
    } else {
      $app_file = file_get_contents($file);
      $app_file = explode($alias1, $app_file);
      $app_file = $app_file['0'] . $alias1 . "\n" . $alias2 . $app_file['1'];
      file_put_contents($file, $app_file);
    }
  }

  private function installSocialite()
  {

      if (version_compare(config('app.version'), '1.9.2') < 0) {
          $this->error('Could not install AntiSocialite SSO Logins, Socalite requires Pterodactyl 1.9.2 or above, you have [' . config('app.version') . '].');
          return 0;
      }

      $this->info('Downloading... AntiSocialite with Composer');
      $this->shell("echo \"yes\" | composer require laravel/socialite"); 

      $this->info('Downloading... Cumcord Driver');
      $this->shell("echo \"yes\" | composer require socialiteproviders/discord");
      
      $this->info("Clearing Laravel Cache");
      $this->shell('php artisan view:clear && php artisan config:clear');

      if (!config()->has('services.socialite')) {
          $this->info("Cleaning up challenges");
          $this->shell('cp config/services.php config/services-backup.php');            
          $this->shell('cp config/services-sl.php config/services.php');            
      }

  }

  private function debug()
  {
    $ip = $this->shell('curl ifconfig.co/ip 2>/dev/null');
    if (!isset($this->install['lic_key'])) {
      $lic_key = $this->ask("Please enter a license key.");
    } else {
      $lic_key = $this->install['lic_key'];
    }
    $this->info("Your license key is: {$lic_key}");
    $this->info("Success. Tell the module developer that you used the debug command so that he checks the data");
  }

  private function setupCron()
  {
    $schedular = $this->shell("crontab -l | grep -q '/billing/scheduler'  && echo 'true' || echo 'false'");
    $version = $this->shell("crontab -l | grep -q 'check_version'  && echo 'true' || echo 'false'");
    if(isset($schedular) AND $schedular == 'false') {
      $this->infoNewLine("Setup scheduler Cron");
      $this->shell('(crontab -l ; echo "0 0 * * * curl '.config('app.url').'/billing/scheduler") | sort - | uniq - | crontab -');
    }

    if(isset($version) AND $version == 'false') {
      $this->shell('(crontab -l ; echo "0 6 * * * cd '.base_path().' && php artisan billing:install check_version") | sort - | uniq - | crontab -');
    }

    return true;
  }

  private function checkVersion()
  {
    $license = \Pterodactyl\Models\Billing\Bill::settings()->getParam('license_key');
    return "6.9.420";
  }

  private function uninstall()
  {
      $this->info('Updating Pterodactyl to the latest version');


      $this->shell('php artisan down');
      $this->shell('cd '.base_path());
      $this->shell('curl -L https://github.com/pterodactyl/panel/releases/latest/download/panel.tar.gz | tar -xzv');
      $this->shell('chmod -R 755 storage/* bootstrap/cache');
      $this->shell('echo \"yes\" | composer install --no-dev --optimize-autoloader');
      $this->shell('php artisan view:clear && php artisan config:clear');
      $this->shell('php artisan migrate --seed --force');

      $this->shell('chown -R www-data:www-data '.base_path().'/*');
      $this->shell('chown -R nginx:nginx '.base_path().'/*');
      $this->shell('chown -R apache:apache '.base_path().'/*');


      $this->shell('php artisan queue:restart');
      $this->shell('php artisan up');
      $this->info('Update Complete - Successfully Installed the latest version of Pterodactyl Panel!');

  }
}