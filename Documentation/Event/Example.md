# Event and Event Dispatcher Example 

* First create Event class.
* Create Event listener Class and invoke the custom event.
* Register the Event listener of custom event in Services.yaml file like.
```sh
      MyVendor\MyExtension\EventListener\MyEventListener: 
        tags:
          - name: event.listener
            identifier: 'FrontendRendring'
            event: MyVendor\MyExtension\Event\MyEvent 
```

* After Add [Event Dispatcher](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Events/EventDispatcher/Index.html) where you want to trigger the event using  
```sh     
      $this->eventDispatcher->dispatch(
            // your event
            new MyEvent()
      );
```