Extended Order Admin module
===========================

## Description

A module for extended views of order management for online merchants + pick lists 
for OXID eShop Community and Professional Edition (formerly part of the core).


![order_list](https://cloud.githubusercontent.com/assets/3603014/11781385/34046c32-a272-11e5-84eb-6489fbe9c847.png)

### Order summary
Displays all products bought, date of the last purchase, amount of items sold and total cost.

![order_summary](https://cloud.githubusercontent.com/assets/3603014/11781387/3426f900-a272-11e5-8db7-4e29344566d6.png)

### Pick list (for packing)
Lists product items that are payed (excl. cash in advance) and not shipped yet. These information can be printed for the warehousepersons.

![pick_list](https://cloud.githubusercontent.com/assets/3603014/11781386/34269672-a272-11e5-9e64-20d4295e8022.png)

[pick_list.pdf](https://github.com/OXIDprojects/extended_order_administration_module/files/61192/pick_list.pdf)

Requirements
------------

* OXID eShop v6.*

## Installation

Please proceed with one of the following ways to install the module:

### Module installation via composer

In order to install the module via composer, run the following commands in commandline of your shop base directory 
(where the shop's composer.json file resides).

```
composer require oxid-projects/extended-order-administration-module
```

### Module installation via repository cloning

Clone the module to your OXID eShop **modules/oe/** directory:
```
git clone https://github.com/OXIDprojects/extended-order-administration-module.git extendedorderadmin
```

### Module installation from zip package

* Make a new folder "extendedorderadmin" in the **modules/oe/ directory** of your shop installation. 
* Download the https://github.com/OXIDprojects/extended-order-administration-module/archive/master.zip file and unpack it into the created folder.

## Activate Module

- Activate the module in the administration panel.

## Uninstall

Disable the module in administration area and/or delete module folder.

## License

Licensing of the software product depends on the shop edition used.
The software for OXID eShop Community Edition is published under the GNU General Public License v3.
You may distribute and/or modify this software according to the licensing terms published by the Free
Software Foundation. Legal licensing terms regarding the distribution of software being subject to GNU
GPL can be found under http://www.gnu.org/licenses/gpl.html.
The software for OXID eShop Professional Edition and Enterprise Edition is released under commercial
license. OXID eSales AG has the sole rights to the software. Decompiling the source code, unauthorized
copying as well as distribution to third parties is not permitted. Infringement will be reported to the
authorities and prosecuted without exception.
