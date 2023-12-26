# Security Guidelines

* All the sql-queries must be made in repository class. not write/define the SQL queries in command/services class.
* "Ensure all user input is encapsulated using [createNamedParameter()](https://github.com/nitsan-technologies/ns_t3dev/blob/0cbf23b889bb524835989dda8e0f1d8578fcff84/Classes/Domain/Repository/ProductAreaRepository.php#L32) within queries generated by the QueryBuilder." to prevent the SQL injection threat.
* In typo3 form, must use the Property mapper cause  If an attacker tries to add a field on the client-side, this is detected by the property mapper, and an exception will be thrown. For example, `<f:form.textbox property="email" />`
* If you want to load the script in fluid template, then load the script file using `<f:asset.script identifier="customJS"><script type="text/javascript">alert("XSS");</script>
  </f:asset.script>` instead of this `<script type="text/javascript">alert("XSS");</script>`
* Never trust user input. So, in forms it must be implemented with validation. And in extbase backend forms, correct tca types or parameters like [eval](https://docs.typo3.org/m/typo3/reference-tca/11.5/en-us/ColumnsConfig/Type/Input/Properties/Eval.html#columns-input-properties-eval) And in the Extbase the [validating framework](https://docs.typo3.org/m/typo3/reference-coreapi/11.5/en-us/ExtensionArchitecture/Extbase/Reference/Validation.html#extbase-validation) can be useful.
* In every logged in form or link must include a secret token that used to check authentication of request. to prevent Cross-site request forgery (XSRF) threat.