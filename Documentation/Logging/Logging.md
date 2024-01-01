# Logging

* #### Logger

  ###### Instantiation and log() method

    ```

      class ProductAreaController extends ActionController implements LoggerAwareInterface {

      use LoggerAwareTrait;


        public function createAction(ProductArea $newProductArea): void
        {
          try{

          }catch (IllegalObjectTypeException | Error $exception){
              $this->logger->error(
                  'An error was occurred in insertion operation'.$exception->getMessage()
              );

          }
        }
      }

    ```


  ###### Custom logTable

  ###### ext_tables.sql


      CREATE TABLE tx_nst3dev_domain_model_log
      (
        uid int(11) NOT NULL auto_increment,
        pid int(11) DEFAULT '0' NOT NULL,

        level tinyint(1) unsigned DEFAULT '0' NOT NULL,
        message text,
        data text,

        PRIMARY KEY (uid),
        KEY parent (pid),
        KEY t3ver_oid (t3ver_oid,t3ver_wsid),
        KEY language (l10n_parent,sys_language_uid)
      );

###### ext_localconf.php

      $GLOBALS['TYPO3_CONF_VARS']['LOG']['NITSAN']['NsT3dev']['Controller']['writerConfiguration'] = [
        LogLevel::INFO => [
            DatabaseWriter::class => [
                'logTable' => 'tx_nst3dev_domain_model_log',
            ],
        ],
    ];













