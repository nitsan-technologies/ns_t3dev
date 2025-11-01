# TYPO3 Code Bank - Extbase Development Reference

**Comprehensive code references and snippets for TYPO3 extension development**

---

## 📚 Important Reference Links

- [Combining Fluid ViewHelpers and TypoScript in TYPO3 5 - Basic Examples](https://stmllr.net/blog/combining-fluid-viewhelpers-and-typoscript-in-typo3-5-basic-examples/)
- [Core API - Useful Functions](https://docs.typo3.org/m/typo3/reference-coreapi/6.2/en-us/ApiOverview/MainClasses/UsefulFunctions/Index.html)
- [Custom Content Post Processing for TYPO3](https://daker.de/post/detail/2018/33/custom-content-post-procession-for-typo3.html)

---

## 🔧 Git Commands

### Clone Repository
```bash
git clone <your-repository-path>
```

### Configure Git User
```bash
git config user.name "Your name"
git config user.email "Your email"
```

### Branch and Commit Operations
```bash
git branch
git fetch origin          # Before checking out new branch
git checkout <branch-name>
git status
git add <your-files-path>
git commit -m "[Label] Your commit message"  # Label: TASK, BUGFIX, FEATURE
git push
```

### Merge Branches
```bash
git checkout <another-branch-where-you-want-to-merge>
git merge <branch-which-you-want-to-merge>
git push
```

### Cache Git HTTPS Credentials
```bash
git config credential.helper "cache --timeout=172800"
```

### Ignore File Permission Changes
```bash
git config core.fileMode false
```

---

## 🖼️ Render Media File Using TypoScript

Render media files from page properties using TypoScript:

```typoscript
5 = FILES
5 {
    begin = 0
    maxItems = 1
    references {
        table = pages
        uid.data = uid
        fieldName = media
    }
    renderObj = TEXT
    renderObj {
        data = file:current:publicUrl
        wrap = <div class="image-section" style="background-image:url('/|')">&nbsp;</div>
    }
}
```

---

## 🌐 Get Current Language UID

### Extbase/Controller (TYPO3 >= 9)
```php
$languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Context\Context::class
)->getAspect('language');
$luid = $languageAspect->getId();
```

### TypoScript (TYPO3 >= 9.5)
```typoscript
currentLang = TEXT
currentLang.dataWrap = {siteLanguage:iso-639-1}
```

---

## 🏷️ Override HTML Tag Using TypoScript

```typoscript
config.htmlTag_stdWrap.cObject = COA
config.htmlTag_stdWrap.cObject {
    wrap = <html style="background-image:url('|');">
    10 = FILES
    10 {
        references.data = levelmedia:-1,slide
        references.listNum = 0
        renderObj = TEXT
        renderObj.data = file:current:publicUrl
    }
}
```

---

## 📦 Conditionally Include JS and CSS

```typoscript
includeJSLibs {
    nsslickjquery = EXT:ns_news_slick/Resources/Public/js/jquery-3.4.1.min.js
    nsslickjquery.if.isTrue = {$plugin.tx_nsnewsslick.includejs.includeJquery}
}
```

---

## 📄 Current Page Field References

Get page properties using cObject:

```typoscript
lib.pagetitle = TEXT
lib.pagetitle.data = page:title
```

---

## 🔁 Inline Nested Loop

Generally used for checkbox checked/unchecked:

```fluid
{f:if(condition:'{x}=={status.uid}', then: 'checked') -> f:for(each: '{statusChecked}', as:'x', iteration: 'i')}
```

---

## 🚀 AJAX Settings for Extbase (Full Configuration)

```typoscript
listAction = PAGE
listAction {
    typeNum = 741852
    config {
        disableAllHeaderCode = 1
        additionalHeaders = Content-type:application/json
        xhtml_cleaning = 0
        admPanel = 0
    }
    10 = USER
    10 < styles.content.get
    10 {
        userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
        extensionName = NsHelpdesk
        pluginName = Helpdesk
        vendorName = NITSAN
        controller = Tickets
        switchableControllerActions {
            Tickets {
                1 = list
            }
        }
        stdWrap.trim = 1
        select {
            where = list_type = "nshelpdesk_helpdesk"
        }
        renderObj < tt_content.list.20.nshelpdesk_helpdesk
    }
}
```

---

## 💾 Database Operations

### Export Database with Gzip
```bash
mysqldump -u <database_name> -p <password> | gzip > /path/to/backup/
```

### Import Database
```bash
mysql -u bode_components -p bode_components_typo3 --binary-mode -o < /srv/www/bode-components.com/TYPO3-10/Database/bode10.sql
```

---

## 🔍 Ke Search Plugin Configuration

```typoscript
lib.ke_search = COA_INT
lib.ke_search {
    10 < plugin.tx_kesearch_pi1
    10.resultPage = 20
    10.cssFile = EXT:ke_search/Resources/Public/Css/ke_search_pi1.css
    10.templateLayout = 11
    10.loadFlexformsFromOtherCE = 305
}
```

---

## 📦 Custom Repository via Composer

### Add Repository
```bash
composer config repositories.nitsan path extension/*
```

### Install Extension
```bash
ddev composer req nitsan/ns-blogfilter:@dev
```

---

## 📊 Fetch Records Using TypoScript

### DatabaseQueryProcessor
```typoscript
jackpotRecords = FLUIDTEMPLATE
jackpotRecords {
    file = EXT:cnty_jackpot/Resources/Private/Templates/Jackpot/ListDce.html
    dataProcessing.10 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
    dataProcessing.10 {
        table = tx_cntyjackpot_domain_model_jackpot
        pidInList = 0
        uidInList.data = field:formElementId
        selectFields.dataWrap = *,FIND_IN_SET(`uid`,'{field:formElementId}') AS jackpotlist_sortby
        where = deleted='0' AND hidden='0'
        orderBy = jackpotlist_sortby
        as = jackpots
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = logo
            }
        }
    }
}
```

---

## 📝 Get Page Property Using TypoScript

```typoscript
pageData = CONTENT
pagaData {
    table = pages
    select {
        uidInList.current = 1
        selectFields = subtitle
    }
    renderObj = COA
    renderObj {
        10 = TEXT
        10.field = subtitle
    }
}
```

---

## 🎯 Set Default Query Settings from Controller

```php
$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    'TYPO3\\CMS\Extbase\\Object\\ObjectManager'
);
$querySettings = $objectManager->get(
    'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings'
);
$querySettings->setRespectStoragePage(FALSE);
$this->frontendUserGroupRepository->setDefaultQuerySettings($querySettings);
```

---

## 🔐 Frontend Login - Fe_login Template Override

```typoscript
plugin.tx_felogin_login {
    templateFile = EXT:ext/Resources/Private/Extensions/Felogin/Templates/Login/Login.html
    settings {
        customPids = {$styles.content.loginform.customPids}
    }
    view {
        templateRootPaths {
            10 = EXT:rsmboilerplate/Resources/Private/Extensions/Felogin/Templates/
        }
        partialRootPaths {
            10 = EXT:rsmboilerplate/Resources/Private/Extensions/Felogin/Partials/
        }
    }
}
```

---

## 🎨 Dynamic Content Rendering from colPose

### Fluid Template Usage
```fluid
<f:cObject typoscriptObjectPath="lib.dynamicContent" data="{colPos: '20'}"/>
```

### TypoScript Configuration
```typoscript
lib.dynamicContent < lib.content
lib.dynamicContent {
    select {
        where.data = field:colPos
        where.wrap = colPos = |
    }
}
```

---

## ✏️ Content Replacement - Title or Word/Slug Generation

### Fluid Template Usage
```fluid
<f:cObject typoscriptObjectPath="lib.contentTitleReplace" data="{YourVariable}"/>
```

### TypoScript Code
```typoscript
contentTitleReplace = TEXT
contentTitleReplace {
    current = 1
    stdWrap.replacement {
        10 {
            search = # #
            replace = -
            useRegExp = 1
        }
    }
    case = lower
}
```

---

## 🎯 Override Field of Child TCA

```php
$GLOBALS['TCA']['tt_content']['types']['rsmboilerplate_textimagegallery'] = [
    'showitem' => $GLOBALS['TCA']['tt_content']['types']['rsmboilerplate_textimagegallery']['showitem'],
    'columnsOverrides' => [
        'image' => [
            'config' => [
                'maxitems' => 1,
                'overrideChildTca' => [
                    'columns' => [
                        'uid_local' => [
                            'config' => [
                                'appearance' => [
                                    'elementBrowserType' => 'file',
                                    'elementBrowserAllowed' => 'png, jpeg, svg, jpg, youtube, mp4, vimeo'
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ]
    ]
];
```

---

## 🔒 TYPO3 10 PHP Content Security Issue Solution

Add to `.htaccess`:

```apache
<IfModule mod_mime.c>
    RemoveType .php
    <FilesMatch ".+\.php$">
        AddType application/x-httpd-php .php
        SetHandler application/x-httpd-php
    </FilesMatch>
</IfModule>
```

---

## 📍 Check Composer/Non-Composer Site-Root Path

```php
if (version_compare(TYPO3_branch, '9.0', '>')) {
    $this->siteRoot = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/';
    $this->composerSiteRoot = \TYPO3\CMS\Core\Core\Environment::getProjectPath() . '/';
    $this->isComposerMode = Environment::isComposerMode();
} else {
    $this->siteRoot = PATH_site;
    $this->isComposerMode = \TYPO3\CMS\Core\Core\Bootstrap::usesComposerClassLoading();
    if ($this->isComposerMode) {
        $commonEnd = explode('/', GeneralUtility::getIndpEnv('TYPO3_DOCUMENT_ROOT'));
        unset($commonEnd[count($commonEnd) - 1]);
        $this->composerSiteRoot = implode('/', $commonEnd) . '/';
    }
}
```

---

## 📌 Get Current TYPO3 Version (v12)

```php
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Information\Typo3Version;

$versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
$versionInformation->getMajorVersion();     // Output: 7 (if 7.3.0)
$versionInformation::BRANCH;                // Output: 12.3
$versionInformation::VERSION;               // Output: 12.3.0
```

---

## 🚪 Before Logout Hook (Below v11)

### Register in ext_localconf.php
```php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['logoff_pre_processing'][]
    = \Vendor\Extension\Hooks\FrontendLogoutHook::class . '->checklogout';
```

### Hooks Class
```php
class FrontendLogoutHook
{
    public function checklogout(array $ref, $userAuth)
    {
        $userId = $userAuth->getSession()->getUserId();
        if (
            $userAuth instanceof \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
            && $userAuth->getLoginFormData()['status'] == 'logout'
            && $userId
        ) {
            // ... do stuff
        }
    }
}
```

---

## 🖼️ Get Flexform Image Value in Controller (v12)

```php
$contentObj = $this->configurationManager->getContentObject();
$fileRepository = GeneralUtility::makeInstance('TYPO3\CMS\Core\Resource\FileRepository');
$fileObjects = $fileRepository->findByRelation('tt_content', 'your-field-name', $contentObj->data['uid']);
$fileObjects[0] = $fileObjects[0] ?? '';
```

---

## 🔎 Use Index_search in Header (v12)

```typoscript
lib.searchBox = USER
lib.searchBox {
    userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
    extensionName = IndexedSearch
    pluginName = Pi2
    vendorName = TYPO3\CMS
    switchableControllerActions {
        Search {
            1 = form
            2 = search
        }
    }
    features {
        requireCHashArgumentForActionArguments = 0
    }
    view =< plugin.tx_indexedsearch.view
    view {
        partialRootPaths.10 = EXT:foo/Resources/Private/IndexedSearch/Partials/
        templateRootPaths.10 = EXT:foo/Resources/Private/IndexedSearch/Templates/
    }
    settings =< plugin.tx_indexedsearch.settings
    settings {
        isSearchBox = TEXT
        isSearchBox.value = 1
        layout = 1
        targetPid = 62
    }
}
```

---

## 🗄️ Ignore Custom Tables from Database Analyser (v12)

### Method 1: Using Events

**Services.yaml**
```yaml
Services:
  Vendor\MyExtension\EventListener\Setup:
    tags:
      - name: event.listener
        identifier: 'table-connection'
        method: 'schemaEvent'
        event: TYPO3\CMS\Core\Database\Event\AlterTableDefinitionStatementsEvent
```

**Setup.php**
```php
<?php
namespace Vendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Event\AlterTableDefinitionStatementsEvent;

class Setup
{
    public function Schema(array $list): array
    {
        $connectionPool = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
        $connection = $connectionPool->getConnectionByName('Default');
        $schemaManager = $connection->createSchemaManager();
        $tables = [];

        foreach ($schemaManager->listTableNames() as $tableName) {
            if (!str_starts_with($tableName, 'wp_')) {
                continue;
            }
            $tables[] = $tableName;
        }

        foreach($tables as $wptable) {
            $query = "SHOW CREATE TABLE `$wptable`";
            $result = $connection->query($query);
            $row = $result->fetch();
            $createTableQuery = $row['Create Table'];
            $createTableQuery = str_replace('"', '`', $createTableQuery);
            $createTableQuery = preg_replace('/CONSTRAINT `[a-zA-Z0-9_-]+` /', '', $createTableQuery);
            $createTableQuery = preg_replace('/ DEFAULT CHARSET=[^ ;]+/', '', $createTableQuery);
            $createTableQuery = preg_replace('/ COLLATE=[^ ;]+/', '', $createTableQuery);
            $list[] = $createTableQuery . ";\n";
        }
        return ['sqlString' => $list];
    }

    public function schemaEvent(AlterTableDefinitionStatementsEvent $event)
    {
        $list = self::Schema([]);
        foreach ($list['sqlString'] ?? [] as $sql) {
            $event->addSqlData($sql);
        }
    }
}
?>
```

### Method 2: Configuration

```php
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Database\\Schema\\ConnectionMigrator'] = [
    'className' => 'Vendor\\ExtensionName\\Database\\Schema\\ConnectionMigrator'
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['DATABASE_COMPARE']['IGNORE_TABLE_PREFIXES'] = [
    'wp_',
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['DATABASE_COMPARE']['IGNORE_TABLE_NAMES'] = [
    'some_table_name',
];
```

---

## 📍 Get Page Property by Passing UID in cObject

### Fluid Template Usage
```fluid
<f:cObject typoscriptObjectPath='lib.pageTitle' data="{uid:<pageId>}"/>
```

### TypoScript Code
```typoscript
lib.pageTitle = RECORDS
lib.pageTitle {
    source.dataWrap = {field:uid}
    tables = pages
    conf.pages = TEXT
    conf.pages.field = title
}
```

---

## 🔔 Signals and Slots - v12 Migration

### Services.yaml
```yaml
Vendor\ExtKey\EventListener\MailEventListener:
  tags:
    - name: event.listener
      identifier: 'your-identifier'
      method: 'manipulateMail'
      event: TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent
```

### PHP Class
```php
final class MailEventListener
{
    public function manipulateMail(
        AfterFlexFormDataStructureParsedEvent $event
    ): void
    {
        // Implementation
    }
}
```

---

## 🧹 Code Quality Tools

### PHPStan
```bash
# Basic usage
/home/nitsan/vendor/bin/phpstan --no-progress [Add two files]

# macOS
Users/nitsan/.composer/vendor/phpstan/phpstan/phpstan --no-progress
```

### PHP-CS-Fixer
```bash
# Fix code style
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix [PathToFileOrExtensions]

# Dry run with diff
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --diff [PathToFileOrExtensions] --dry-run

# macOS
/Users/nitsan/.composer/vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix [PathToFileOrExtensions]
```

### PHPStan Configuration

**phpstan.neon**
```yaml
includes:
  - phpstan-baseline.neon

parameters:
  parallel:
    maximumNumberOfProcesses: 5
  level: 3
  bootstrapFiles:
    - /home/nitsan/Workspace/v12-composer/vendor/autoload.php
  paths:
    - Classes
    - Configuration
  scanDirectories:
    - Classes
    - Configuration
```

**phpstan-baseline.neon**
```yaml
parameters:
  ignoreErrors:
```

---

## 🔄 Create SwitchableControllerActions Migration Script

```php
<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

final class SwitchableUpgradeWizard implements UpgradeWizardInterface
{
    private const MIGRATION_SETTINGS = [
        [
            'switchableControllerActions' => 'switchableControllerActions type',
            'targetListType' => 'new list type',
        ],
    ];

    public function getIdentifier(): string
    {
        return 'myExtension_exampleUpgradeWizard';
    }

    public function getTitle(): string
    {
        return 'switchableControllerActions migration';
    }

    public function getDescription(): string
    {
        return 'migration script for switchableControllerActions';
    }

    public function executeUpdate(): bool
    {
        $success = false;
        try {
            foreach (self::MIGRATION_SETTINGS as $list_type) {
                $success = $this->getMigrationRecords($list_type);
            }
        } catch (\Throwable $th) {
            return false;
        }
        return $success;
    }

    public function updateNecessary(): bool
    {
        return true;
    }

    public function getPrerequisites(): array
    {
        return [];
    }

    public function performMigration(): bool
    {
        return true;
    }

    protected function getMigrationRecords($list_type)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');
        try {
            $queryBuilder
                ->update('tt_content')
                ->where(
                    $queryBuilder->expr()->like(
                        'pi_flexform',
                        $queryBuilder->createNamedParameter(
                            '%' . $queryBuilder->escapeLikeWildcards(
                                $list_type['switchableControllerActions']
                            ) . '%'
                        )
                    )
                )
                ->set('list_type', $list_type['targetListType'])
                ->executeStatement();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
?>
```

**Register in ext_localconf.php**
```php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['myExtension_exampleUpgradeWizard']
    = \Vendor\Extension\Upgrades\SwitchableUpgradeWizard::class;
```

---

## 🎲 Fetch Random Records Using TypoScript

```typoscript
lib.randomRecords = CONTENT
lib.randomRecords {
    table = tt_content
    select {
        selectFields = uid, header, bodytext, RAND() as random_value
        orderBy = random_value
        max = 3
    }
    renderObj = FLUIDTEMPLATE
    renderObj {
        file = fileadmin/RandomRecords.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = bodytext
            }
        }
    }
}
```

---

## 🔀 TypoScript Page Redirect

Redirect pages based on conditions:

```typoscript
[traverse(page, "uid") == 49]
config.additionalHeaders {
    10 {
        header = Location: https://example.com
    }
}
[end]
```

---

## 📧 Mail Configuration for DDEV

### Gmail Configuration
```php
'MAIL' => [
    'defaultMailFromName' => '0',
    'transport' => 'smtp',
    'transport_sendmail_command' => '/usr/sbin/sendmail -t -i ',
    'transport_smtp_encrypt' => 'ssl',
    'transport_smtp_password' => '***********',
    'transport_smtp_server' => 'smtp.gmail.com:465',
    'transport_smtp_username' => 'abc@xyz.com',
],
```

### Default MailHog Configuration
```php
'MAIL' => [
    'transport' => 'sendmail',
    'transport_sendmail_command' => '/usr/local/bin/mailhog sendmail test@example.org --smtp-addr 127.0.0.1:1025',
    'transport_smtp_encrypt' => '',
    'transport_smtp_password' => '',
    'transport_smtp_server' => '',
    'transport_smtp_username' => '',
],
```

---

## 🖼️ Usage of CropVariant ImageManipulation in Templating

```html
<picture class="lozad"
    data-iesrc="{f:uri.image(image:'{eventImg.0}', width:'170c', height:'205c')}"
    data-alt="{eventImg.0.alternative}">
    <source
        srcset="{f:uri.image(image: '{eventImg.0}' ,cropVariant: 'specialDesktop')}"
        media="(min-width: 1200px)">
    <source
        srcset="{f:uri.image(image: '{eventImg.0}', cropVariant: 'specialTablet')}"
        media="(min-width: 768px)">
    <source
        srcset="{f:uri.image(image: '{eventImg.0}', cropVariant: 'specialMobile')}">
    <img title="{eventImg.0.title}" src="data:," alt="{image.0.alternative}"
        maxWidth="{content.maxWidth}" class="event-accordion-img">
</picture>
```

---

## 🚫 Prevent Extra &nbsp; in RTE (TYPO3 >= 12)

Extra non-breaking spaces are appended in `css_transform` mode. Remove this mode:

```typoscript
RTE.default.proc.overruleMode = detectbrokenlinks,ts_links
```

Or set to none:
```typoscript
RTE.default.proc.overruleMode = none
```

**References:**
- [RTE Transformations in Content Elements](https://docs.typo3.org/m/typo3/reference-coreapi/12.4/en-us/ApiOverview/Rte/HistoricalRteTransformations/RteTransformationsInContentElements.html)
- [RTE Transformations Introduction](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Rte/Transformations/Introduction.html#transformations-where)

---

## 🌳 Render Filelist Tree With Module

### TYPO3 >= v12
```php
'navigationComponent' => '@typo3/backend/tree/file-storage-tree-container'
```

### TYPO3 v11
```php
'navigationComponentId' => 'TYPO3/CMS/Backend/Tree/FileStorageTreeContainer'
```

### TYPO3 v10
```php
'navigationFrameModule' => 'file_navframe'
'workspaces' => 'online'
```

---

## 🛠️ Extend TYPO3 Backend Core Extension's Template

### TYPO3 > v12
```typoscript
templates.typo3/cms-belog.1643293191 = nitsan/ns-t3ai:Resources/Private/Backend/BeLog
```

### TYPO3 < v11
```typoscript
module.tx_belog.view {
    partialRootPaths {
        20 = EXT:ns_t3ai/Resources/Private/Backend/BeLog/Partials/
    }
}
```

---

## 🔍 Solr Container Setup for TYPO3 v13

1. Download the extension from [TYPO3-Solr/ext-solr](https://github.com/TYPO3-Solr/ext-solr)
2. Place it in your project's `packages` folder
3. Delete when updating/installing composer
4. Add back when running `ddev start` or `ddev restart`

---

## 👤 Contact Information

**NITSAN - TYPO3 Development**

- **Website:** www.t3planet.de
- **Email:** info@t3planet.de

---

## 📄 Document Credits

This comprehensive code bank is a collection of TYPO3 development references compiled by NITSAN team with contributions from various developers and the TYPO3 community.

**Document Version:** 1.0
**Last Updated:** 2024

---
