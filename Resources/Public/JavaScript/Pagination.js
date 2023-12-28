require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
  // Generate a random number between 1 and 32
  const randomNumber = Math.ceil(Math.random() * 32);
  new AjaxRequest(TYPO3.settings.ajaxUrls.beproductarea_list)
    .withQueryArguments({input: randomNumber})
    .get()
    .then(async function (response) {
      const resolved = await response.resolve();
      console.log(resolved.result);
    });
});
