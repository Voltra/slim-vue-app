---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Front-end
nav_order: 2
title: Babel
---

Babel is configured to use `core-js@3` for polyfills (on use) and to bundle the code in UMD.

It brings a lot of custom propositions and utils:

## Vue JSX

In addition to supporting JSX syntax it allows for a few handy things:
* [automatic resolution of the `h` function](https://www.npmjs.com/package/@vue/babel-sugar-inject-h#details)
* [make a functional component out of an arrow function that returns JSX](https://www.npmjs.com/package/@vue/babel-sugar-functional-vue#details) if the variable name uses Pascal Case
* [syntactic sugar for `vModel`](https://www.npmjs.com/package/@vue/babel-sugar-v-model)
* [syntactic sugar for `vOn`](https://www.npmjs.com/package/@vue/babel-sugar-v-on)

## Function binding

This allows to bind methods and/or functions with a nice syntax:
```javascript
obj::func === func.bind(obj);
::obj.method === obj.method.bind(obj);

obj::func(...args) === func.call(obj, ...args);
::obj.method(...args) === obj.method.call(obj, ...args);
```

## Class properties

This allows to declare class properties directly inside the class:
```javascript
class User extends Model{
	table = "users";
}

(new User()).table === "users";
```

## Do expressions

Useful expressions to conditionally return values, especially for JSX:
```javascript
const two = do{
	if(false)
		0;
	else
		2;
};

two === 2;

// this is equivalent to

const two = (() => {
	if(false)
		return 0;
	else
		return 2;
})();
```

## Numeric separator

Increases readability of hardcoded numbers:
```javascript
const twoK = 2_000;
```

## Null coalescing

Allows for conditional default value assignment on `null`:
```javascript
const stuff = null ?? "stuff";
stuf === "stuff";

const undef = undefined ?? 42;
undef === undefined;
```

## Optional chaining

Allows for cleaner code on complex embedded object structures:
```javascript
window?.might?.have?.that?.property?.doStruff();

const failed = obj?.prop?.subprop;
!failed;
```

## Throw expressions

Allows `throw` statements to be parsed as expressions instead:
```javascript
onFailure(() => throw new Error("throws as expr"));

// equivalent to

onFailure(() => { throw new Error("throws as expr"); });
```

## Pipeline operator

Allows for easy nested function applications without the parentheses' headache:
```javascript
const fortyTwo = '1' |> parseFloat |> timesTwo |> plusFourty;
fortyTwo === 42;
```

## Partial application

In combination with the bind operator and the pipeline operator, this makes the ultimate function call toolbox:
```javascript
doStuff(?, 42) === (x => doStuff(x, 42));

"2A" |> parseInt(?, 16) |> ::socket.send; // socket.send(parseInt("2A", 16)) --> socket.send(42)
```

## Dynamic import

Supports dynamic import statements for code splitting (aka imports as a promise):

```javascript
async function doStuff(){
	const myModule = await import("my-module");
	// Do stuff
}
```
