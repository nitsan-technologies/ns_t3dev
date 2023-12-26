# Event and Event Dispatcher 

* First create Custom Event class For event And containing all information to be transported to the listeners and this is basic php class that contain methods and member variables. check here [FrontendRendringEvent](https://github.com/nitsan-technologies/ns_t3dev/blob/feature/frontend-event/Classes/Event/FrontendRendringEvent.php#L7).
* Then Create EventListner Class of this Event in Classes Folder
* [Register the Event listener](https://docs.typo3.org/m/typo3/reference-coreapi/11.5/en-us/ApiOverview/Events/EventDispatcher/Index.html#registering-the-event-listener) of custom event in [Services.yaml](https://github.com/nitsan-technologies/ns_t3dev/blob/feature/frontend-event/Configuration/Services.yaml) file like.
```sh
MyVendor\MyExtension\EventListener\MyEventListener: 
      tags:
            - name: event.listener
            identifier: 'myeventidentifier'
            event: MyVendor\MyExtension\Event\MyEvent 
```
* Then invoke the Event in EventListner Class check here [FrontendRendringEventListener](https://github.com/nitsan-technologies/ns_t3dev/blob/feature/frontend-event/Classes/EventListener/FrontendRendringEventListener.php).
```sh 
public function __invoke(MyEvent $event): void
{
      //write your logic here
}
```
* Create an event object with the data that should be passed to the listeners. Use the data as it suits your business logic:
* If no attribute method is given, the class is treated as invokable, thus its __invoke() method will be called:
* After Add [Event Dispatcher](https://github.com/nitsan-technologies/ns_t3dev/blob/99a9fe6b13535e6f4aee7eeaad10ed55a061b21d/Classes/Controller/ProductAreaController.php#L46)
```sh     
$this->eventDispatcher->dispatch(
      // your event
      new MyEvent()
);
```
* A complete list of all registered event listeners can be viewed in the the module `System > Configuration > Event Listeners (PSR-14)`.


