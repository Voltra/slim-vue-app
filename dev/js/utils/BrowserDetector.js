/**
 * @class BrowserDetector
 * @classdesc A class used for JS browser/platform detection
 */
class BrowserDetector{
	/**
	 * Construct a new {@link BrowserDetector}
	 * @param {typeof globalThis} global
	 */
	constructor(global = window){
		this.global = global;
		this.navigator = this.global.navigator;
		this.ua = this.navigator.userAgent.toLowerCase();
		this.vendor = this.navigator.vendor.toLowerCase() || "";
		this.platform = this.navigator.platform.toLowerCase();

		this.bootstrapped = false;
	}

	// CSS Setup
	/**
	 * Add CSS classes to the document (on the <html> tag)
	 * @returns {BrowserDetector}
	 */
	bootstrapClasses(){
		if(this.bootstrapped)
			return this;

		const html = this.global.document.documentElement;

		[
			//Browsers
			"ie",
			"edge",
			"chrome",
			"opera",
			"firefox",
			"safari",
			"vivaldi",

			//Specific Browsers
			"chromeIOS",
			"ieMobile",

			//Platforms
			"windows",
			"mac",
			"linux",
			"android",
			"blackberry",
			"ios",

			//Type
			"desktop",
			"mobile",
		].forEach(browser => {
			if(this[browser])
				html.classList.add(browser);
		});

		return this;
	}

	// Pure browsers
	get ie(){
		return this.ua.includes("msie") || this.ua.includes("trident");
	}

	get edge(){
		return this.ua.includes("edg"); // new edge uses Edg instead of Edge
	}

	get chrome(){
		return this.ua.includes("chrome")
            && this.vendor.includes("google")
            && !this.opera
            //&& !this.safari()
            && !this.vivaldi;
	}

	get opera(){
		return typeof this.global.opr !== "undefined";
	}

	get firefox(){
		return this.ua.includes("firefox");
	}

	get safari(){
		return this.ua.includes("safari")
        && !this.vivaldi
        && !this.chrome
		&& !this.edge;
	}

	get vivaldi(){
		return this.ua.includes("vivaldi");
	}


	// Specific browsers
	get chromeIOS(){
		return this.ua.includes("crios");
	}

	get ieMobile(){
		return this.ua.includes("iemobile");
	}

	// Platform
	get windows(){
		return this.platform.includes("win");
	}

	get mac(){
		return this.platform.includes("mac");
	}

	get linux(){
		return this.platform.includes("linux");
	}

	get android(){
		return this.ua.includes("android");
	}

	get ios(){
		return /i(phone|pad|pod)/i.test(this.ua);
	}

	get blackberry(){
		return this.ua.includes("blackberry");
	}

	// Type
	get desktop(){
		return !this.mobile;
	}

	get mobile(){
		return [
			"chromeIOS",
			"ieMobile",

			"android",
			"ios",
			"blackberry",
		].some(browser => this[browser]);
	}
}

const browserDetectorOf = (global = window) => new BrowserDetector(global);

export { browserDetectorOf };
