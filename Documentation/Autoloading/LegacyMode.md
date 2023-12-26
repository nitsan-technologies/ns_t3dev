* Guideline for autoloading in Typo3 Legacy Mode

Following steps will use to autoload class in typo3 Legacy mode.

* Step 1: Put any PHP Library or SDK in Extension's Classes directory
* Step 2: In `ext_emconf.php` add following code in key `autoload`
* ``'autoload' => [
  'classmap' => ['Classes/']
  ]``
* Step 3: Do Typo3 dumpautoload and cache Clear

***
* Following Reference are for autoloading
* Ref 1: https://www.youtube.com/watch?v=p_Ll2mKkz70&t=634s
* Ref 2: https://docs.typo3.org/m/typo3/reference-coreapi/11.5/en-us/ApiOverview/Autoloading/Index.html
* Ref 3 : https://docs.typo3.org/m/typo3/reference-coreapi/11.5/en-us/ExtensionArchitecture/FileStructure/ExtEmconf.html#extension-declaration
