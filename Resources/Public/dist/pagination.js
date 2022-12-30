class Paginate {
  constructor(data) {
    this.paginationType = data.paginationType;
    this.containerWraper = data.containerWraper;
    this.paginateClass = data.paginateClass;
    this.extensionName = data.extensionName;
    this.pluginName = data.pluginName;
    this.controller = data.controller;
    this.action = data.action;
    this.pageType = data.pageType;
    this.targetContainer = data.targetContainer;
  }

  initLink = async () => {
    let pages = document.querySelectorAll(this.paginateClass);
    let container = document.querySelector(this.containerWraper);
    // container.innerHTML = "";
    if (pages && pages.length) {
      for (let i = 0; i < pages.length; i++) {
        try {
          pages[i].addEventListener(
            "click",
            async (e) => {
              e.preventDefault();
              try {
                const response = await fetch(
                  `${pages[i].getAttribute("href")}`
                );
                let data = await response.text();
                if (
                  this.targetContainer !== "" &&
                  this.targetContainer !== "undefined" &&
                  this.targetContainer != null
                ) {
                  let parser = new DOMParser();
                  let doc = parser.parseFromString(data, "text/html");
                  let newdata = doc.querySelectorAll(this.targetContainer);
                  if (newdata && newdata.length) {
                    let newData1 = " ";
                    newdata.forEach((d) => {
                      newData1 += d.innerHTML;
                    });
                    data = newData1;
                  }
                }
                if (pages.length === 1) {
                  container.innerHTML += data;
                } else {
                  container.innerHTML = data;
                }
                // container = document.querySelector(this.containerWraper);
              } catch (error) {
                console.log(error);
              }
            },
            false
          );
        } catch (error) {}
      }
    }
  };
}
