<div align="center">
    <img src="https://bagisto.com/wp-content/themes/bagisto/images/logo.png" alt="Bagisto Logo" />
    <h2>Azure single sign-on (SSO)</h2>
</div>

<div align="center">
    <img alt="GitHub version" src="https://img.shields.io/github/v/release/bagisto-europe/admin-azure-auth">
    <img alt="Packagist Downloads" src="https://img.shields.io/packagist/dt/bagisto-eu/azure-auth">
    <img alt="GitHub license" src="https://img.shields.io/github/license/bagisto-europe/admin-azure-auth">
</div>

With this package, you can integrate Microsoft Azure Single Sign-On (SSO) into the Bagisto admin panel.  

- Users can use a single set of credentials to access various applications, including Bagisto.
- Utilizes modern security protocols and provides additional security layers, such as multi-factor authentication (MFA).
- Seamless integration with Azure SSO to streamline authentication processes within the existing Azure environment.
- Azure SSO provides comprehensive monitoring and reporting capabilities.
- Administrators can gain insights into user activity, login attempts, and other relevant data, aiding in security management and issue resolution.
- It is designed to be scalable and can be tailored to the growing needs of an organization.

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
