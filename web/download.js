"use strict";

var useragent = [];
useragent.push('Opera/9.80 (X11; Linux x86_64; U; fr) Presto/2.9.168 Version/11.50');
useragent.push('Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25');
useragent.push('Opera/12.02 (Android 4.1; Linux; Opera Mobi/ADR-1111101157; U; en-US) Presto/2.9.201 Version/12.02');

var page = require('webpage').create();
var system = require('system');

var siteUrl = system.args[1];

page.customHeaders = {
  ":method": "GET",
  ":scheme": "https",
  ":version": "HTTP/1.1",
  "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
  "accept-language": "ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
  "cache-control": "max-age=0",
  "upgrade-insecure-requests": "1",
  "user-agent": useragent[Math.floor(Math.random() * useragent.length)]
};


page.onResourceRequested = function (requestData, request) {
  if ((/http:\/\/.+?\.css$/gi).test(requestData['url'])) {
    request.abort();
  }
  if (
      (/\.doubleclick\./gi.test(requestData['url'])) ||
      (/\.pubmatic\.com$/gi.test(requestData['url'])) ||
      (/yandex/gi.test(requestData['url'])) ||
      (/google/gi.test(requestData['url'])) ||
      (/gstatic/gi.test(requestData['url']))
  ) {
    request.abort();
    return;
  }
};

page.onError = function (msg, trace) {
  console.log(msg);
  trace.forEach(function (item) {
    // console.log('  ', item.file, ':', item.line);
  });
};

var page = new WebPage()
var fs = require('fs');

page.onLoadFinished = function() {
  console.log("page load finished");
  setTimeout(function() {
    return document.documentElement.outerHTML
  }, 3000);
  
  var fn = "/var/www/parser/web/uploads/cache/debugjs.html";
  console.log("fn");
  fs.write(fn, page.content, function(err) {
    if(err) {
        return console.log(err);
    }
		console.log("The file was saved!");
	});
  phantom.exit();
};

page.open(siteUrl, function() {
  page.evaluate(function() {
  });
});