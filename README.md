<div align="center">
    <img src="https://bagisto.com/wp-content/themes/bagisto/images/logo.png" alt="Bagisto Logo" />
    <h2>Azure single sign-on (SSO)</h2>
</div>

<div align="center">
    <img alt="GitHub version" src="http://poser.pugx.org/bagisto-eu/azure-auth/v">
    <img alt="GitHub license" src="https://img.shields.io/github/license/bagisto-europe/admin-azure-auth">
</div>

Integrate Microsoft Azure Single Sign On and benefit from a secure login experience in the Bagisto admin panel.

## Changelog

See [Changelog](CHANGELOG.md) for details on what has changed in each version.

## Installation

1. Install the package using Composer

```bash
    composer require bagisto-eu/azure-auth
```

2. Run the following command to configure your credentials

```bash
    php artisan azure:configure
```

During the configuration, you will be prompted to enter your Client ID, Client Secret, and Tenant ID.  
If you don't have these credentials, you can obtain them at [https://portal.azure.com](https://portal.azure.com).  

3. Open your admin panel you should see the option to Sign in with Microsoft

![example](docs/bagisto-signin.png)

## Support

For support or any inquiries, please contact us at [info@bagisto.eu](mailto:info@bagisto.eu).
