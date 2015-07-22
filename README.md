## WHMCS modules for DomainCloud Reseller

- - - -

About | Description
------------ | -------------
Stable tag | 0.9.0
Tested on | WHMCS 5.3
License | GPLv2 or later
License URI | http://www.gnu.org/licenses/gpl-2.0.html

### Installation

If you have any troubles during installation please contact us at registrar[at]isi.co.id.

### Setting up the reseller modules

1. Put reseller files and folders to your WHMCS system path (e.g: `/var/www/html`).
2. Activate domainku registrar module and document management addon on your WHMCS system.
3. Configure these modules using credentials provided by us.
4. Create an administrator user named `resellerapi` on your WHMCS system.
5. Create an email template named 'Domain Registration Approved'. Please read `domain registration approved_-_email template.txt` for further information.
6. Configure upload path and API endpoint on `/modules/addons/domaincloud/config.php` and `/modules/registrars/domainku/config.php`.
7. Change your admin area template to `domaincloud`.
