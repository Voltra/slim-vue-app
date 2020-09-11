import { add } from "../demo";

describe("Demo", function(){
	it("should do math", function(){
		expect(1 + 1).toBe(2);
	});

	it("should get additions right", function(){
		expect(add(40, 2)).toBe(42);
	});
});
