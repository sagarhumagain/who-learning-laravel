/*! For license information please see register.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[844],{5662:(e,t,r)=>{r.r(t),r.d(t,{default:()=>k});var n=r(8222),o={class:"container h-100"},i={class:"row h-100 align-items-center"},a={class:"col-12 col-md-6 offset-md-3"},c={class:"card shadow sm mt-4 rounded-0"},l={class:"card-body"},s=(0,n.createElementVNode)("div",{class:"text-center"},[(0,n.createElementVNode)("img",{src:"/images/logo.png",alt:"WHO Logo",height:"100"})],-1),u=(0,n.createElementVNode)("h1",{class:""},"Register",-1),f=(0,n.createElementVNode)("hr",null,null,-1),d={class:"form-group col-12"},h=(0,n.createElementVNode)("label",{for:"name",class:"font-weight-bold"},"Name",-1),p={class:"form-group col-12"},m=(0,n.createElementVNode)("label",{for:"email",class:"font-weight-bold"},"Email",-1),v={class:"form-group col-12"},y=(0,n.createElementVNode)("label",{for:"password",class:"font-weight-bold"},"Password",-1),g={class:"form-group col-12"},w=(0,n.createElementVNode)("label",{for:"password_confirmation",class:"font-weight-bold"},"Confirm Password",-1),b={class:"col-12 mb-2 text-center"},E=["disabled"],x={class:"col-12 text-center mt-3"};function N(e){return N="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},N(e)}function V(){V=function(){return e};var e={},t=Object.prototype,r=t.hasOwnProperty,n="function"==typeof Symbol?Symbol:{},o=n.iterator||"@@iterator",i=n.asyncIterator||"@@asyncIterator",a=n.toStringTag||"@@toStringTag";function c(e,t,r){return Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{c({},"")}catch(e){c=function(e,t,r){return e[t]=r}}function l(e,t,r,n){var o=t&&t.prototype instanceof f?t:f,i=Object.create(o.prototype),a=new O(n||[]);return i._invoke=function(e,t,r){var n="suspendedStart";return function(o,i){if("executing"===n)throw new Error("Generator is already running");if("completed"===n){if("throw"===o)throw i;return j()}for(r.method=o,r.arg=i;;){var a=r.delegate;if(a){var c=b(a,r);if(c){if(c===u)continue;return c}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if("suspendedStart"===n)throw n="completed",r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n="executing";var l=s(e,t,r);if("normal"===l.type){if(n=r.done?"completed":"suspendedYield",l.arg===u)continue;return{value:l.arg,done:r.done}}"throw"===l.type&&(n="completed",r.method="throw",r.arg=l.arg)}}}(e,r,a),i}function s(e,t,r){try{return{type:"normal",arg:e.call(t,r)}}catch(e){return{type:"throw",arg:e}}}e.wrap=l;var u={};function f(){}function d(){}function h(){}var p={};c(p,o,(function(){return this}));var m=Object.getPrototypeOf,v=m&&m(m(L([])));v&&v!==t&&r.call(v,o)&&(p=v);var y=h.prototype=f.prototype=Object.create(p);function g(e){["next","throw","return"].forEach((function(t){c(e,t,(function(e){return this._invoke(t,e)}))}))}function w(e,t){function n(o,i,a,c){var l=s(e[o],e,i);if("throw"!==l.type){var u=l.arg,f=u.value;return f&&"object"==N(f)&&r.call(f,"__await")?t.resolve(f.__await).then((function(e){n("next",e,a,c)}),(function(e){n("throw",e,a,c)})):t.resolve(f).then((function(e){u.value=e,a(u)}),(function(e){return n("throw",e,a,c)}))}c(l.arg)}var o;this._invoke=function(e,r){function i(){return new t((function(t,o){n(e,r,t,o)}))}return o=o?o.then(i,i):i()}}function b(e,t){var r=e.iterator[t.method];if(void 0===r){if(t.delegate=null,"throw"===t.method){if(e.iterator.return&&(t.method="return",t.arg=void 0,b(e,t),"throw"===t.method))return u;t.method="throw",t.arg=new TypeError("The iterator does not provide a 'throw' method")}return u}var n=s(r,e.iterator,t.arg);if("throw"===n.type)return t.method="throw",t.arg=n.arg,t.delegate=null,u;var o=n.arg;return o?o.done?(t[e.resultName]=o.value,t.next=e.nextLoc,"return"!==t.method&&(t.method="next",t.arg=void 0),t.delegate=null,u):o:(t.method="throw",t.arg=new TypeError("iterator result is not an object"),t.delegate=null,u)}function E(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function x(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function O(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(E,this),this.reset(!0)}function L(e){if(e){var t=e[o];if(t)return t.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var n=-1,i=function t(){for(;++n<e.length;)if(r.call(e,n))return t.value=e[n],t.done=!1,t;return t.value=void 0,t.done=!0,t};return i.next=i}}return{next:j}}function j(){return{value:void 0,done:!0}}return d.prototype=h,c(y,"constructor",h),c(h,"constructor",d),d.displayName=c(h,a,"GeneratorFunction"),e.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===d||"GeneratorFunction"===(t.displayName||t.name))},e.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,h):(e.__proto__=h,c(e,a,"GeneratorFunction")),e.prototype=Object.create(y),e},e.awrap=function(e){return{__await:e}},g(w.prototype),c(w.prototype,i,(function(){return this})),e.AsyncIterator=w,e.async=function(t,r,n,o,i){void 0===i&&(i=Promise);var a=new w(l(t,r,n,o),i);return e.isGeneratorFunction(r)?a:a.next().then((function(e){return e.done?e.value:a.next()}))},g(y),c(y,a,"Generator"),c(y,o,(function(){return this})),c(y,"toString",(function(){return"[object Generator]"})),e.keys=function(e){var t=[];for(var r in e)t.push(r);return t.reverse(),function r(){for(;t.length;){var n=t.pop();if(n in e)return r.value=n,r.done=!1,r}return r.done=!0,r}},e.values=L,O.prototype={constructor:O,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(x),!e)for(var t in this)"t"===t.charAt(0)&&r.call(this,t)&&!isNaN(+t.slice(1))&&(this[t]=void 0)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var t=this;function n(r,n){return a.type="throw",a.arg=e,t.next=r,n&&(t.method="next",t.arg=void 0),!!n}for(var o=this.tryEntries.length-1;o>=0;--o){var i=this.tryEntries[o],a=i.completion;if("root"===i.tryLoc)return n("end");if(i.tryLoc<=this.prev){var c=r.call(i,"catchLoc"),l=r.call(i,"finallyLoc");if(c&&l){if(this.prev<i.catchLoc)return n(i.catchLoc,!0);if(this.prev<i.finallyLoc)return n(i.finallyLoc)}else if(c){if(this.prev<i.catchLoc)return n(i.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return n(i.finallyLoc)}}}},abrupt:function(e,t){for(var n=this.tryEntries.length-1;n>=0;--n){var o=this.tryEntries[n];if(o.tryLoc<=this.prev&&r.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===e||"continue"===e)&&i.tryLoc<=t&&t<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=e,a.arg=t,i?(this.method="next",this.next=i.finallyLoc,u):this.complete(a)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),u},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.finallyLoc===e)return this.complete(r.completion,r.afterLoc),x(r),u}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.tryLoc===e){var n=r.completion;if("throw"===n.type){var o=n.arg;x(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(e,t,r){return this.delegate={iterator:L(e),resultName:t,nextLoc:r},"next"===this.method&&(this.arg=void 0),u}},e}function O(e,t,r,n,o,i,a){try{var c=e[i](a),l=c.value}catch(e){return void r(e)}c.done?t(l):Promise.resolve(l).then(n,o)}function L(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function j(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?L(Object(r),!0).forEach((function(t){P(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):L(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function P(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const _={name:"register",data:function(){return{user:{name:"",email:"",password:"",password_confirmation:""},processing:!1}},methods:j(j({},(0,r(3907).nv)({signIn:"auth/login"})),{},{register:function(){var e,t=this;return(e=V().mark((function e(){return V().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.processing=!0,e.next=3,axios.post("/register",t.user).then((function(e){t.signIn(),window.location.reload()})).catch((function(e){var t=e.response.data;alert(t.message)})).finally((function(){t.processing=!1}));case 3:case"end":return e.stop()}}),e)})),function(){var t=this,r=arguments;return new Promise((function(n,o){var i=e.apply(t,r);function a(e){O(i,n,o,a,c,"next",e)}function c(e){O(i,n,o,a,c,"throw",e)}a(void 0)}))})()}})};const k=(0,r(3744).Z)(_,[["render",function(e,t,r,N,V,O){var L=(0,n.resolveComponent)("router-link");return(0,n.openBlock)(),(0,n.createElementBlock)("div",o,[(0,n.createElementVNode)("div",i,[(0,n.createElementVNode)("div",a,[(0,n.createElementVNode)("div",c,[(0,n.createElementVNode)("div",l,[s,u,f,(0,n.createElementVNode)("form",{action:"javascript:void(0)",onSubmit:t[4]||(t[4]=function(){return O.register&&O.register.apply(O,arguments)}),class:"row",method:"post"},[(0,n.createElementVNode)("div",d,[h,(0,n.withDirectives)((0,n.createElementVNode)("input",{type:"text",name:"name","onUpdate:modelValue":t[0]||(t[0]=function(e){return V.user.name=e}),id:"name",placeholder:"Enter name",class:"form-control"},null,512),[[n.vModelText,V.user.name]])]),(0,n.createElementVNode)("div",p,[m,(0,n.withDirectives)((0,n.createElementVNode)("input",{type:"text",name:"email","onUpdate:modelValue":t[1]||(t[1]=function(e){return V.user.email=e}),id:"email",placeholder:"Enter Email",class:"form-control"},null,512),[[n.vModelText,V.user.email]])]),(0,n.createElementVNode)("div",v,[y,(0,n.withDirectives)((0,n.createElementVNode)("input",{type:"password",name:"password","onUpdate:modelValue":t[2]||(t[2]=function(e){return V.user.password=e}),id:"password",placeholder:"Enter Password",class:"form-control"},null,512),[[n.vModelText,V.user.password]])]),(0,n.createElementVNode)("div",g,[w,(0,n.withDirectives)((0,n.createElementVNode)("input",{type:"password",name:"password_confirmation","onUpdate:modelValue":t[3]||(t[3]=function(e){return V.user.password_confirmation=e}),id:"password_confirmation",placeholder:"Enter Password",class:"form-control"},null,512),[[n.vModelText,V.user.password_confirmation]])]),(0,n.createElementVNode)("div",b,[(0,n.createElementVNode)("button",{type:"submit",disabled:V.processing,class:"btn-fill mt-3"},(0,n.toDisplayString)(V.processing?"Please wait":"Register"),9,E)]),(0,n.createElementVNode)("div",x,[(0,n.createElementVNode)("label",null,[(0,n.createTextVNode)("Already have an account? "),(0,n.createVNode)(L,{to:{name:"login"}},{default:(0,n.withCtx)((function(){return[(0,n.createTextVNode)("Login Now!")]})),_:1})])])],32)])])])])])}]])}}]);