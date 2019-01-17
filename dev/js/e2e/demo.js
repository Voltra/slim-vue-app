module.exports = {
	"Demo": function(browser){
		browser.url("https://google.fr")
		.pause(1000)
		.expect.element("body").to.be.present.before(1000)
		.end();
	}
};