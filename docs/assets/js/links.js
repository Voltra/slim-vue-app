const domParser = new DOMParser();
const dom = domParser.parseFromString(`
	<span class="ico-ext">
		&nbsp;
		<i class='fas fa fa-external-link'></i>
	</span>`,
"text/html");

const html = dom.body.innerHTML;

document.querySelectorAll("a[target=_blank]")
	.forEach(e => e.innerHTML += html);
