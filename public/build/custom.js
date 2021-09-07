(self["webpackChunk"] = self["webpackChunk"] || []).push([["custom"],{

/***/ "./assets/custom.js":
/*!**************************!*\
  !*** ./assets/custom.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.parse-int.js */ "./node_modules/core-js/modules/es.parse-int.js");

__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");

__webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");

var user = document.getElementById('users_list');

if (user) {
  user.addEventListener('click', function (e) {
    if (e.target.className === 'btn btn-danger delete-user') {
      if (confirm('Are you sure?')) {
        var id = parseInt(e.target.getAttribute('data-id'));

        if (id) {
          fetch('/users/delete/' + id, {
            method: 'GET'
          }).then(function (res) {
            return window.location.reload();
          });
        } else {
          alert('No data id found');
        }
      } else {
        return false;
      }
    }
  });
}

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_export_js-node_modules_core-js_internals_function-bind-7be9a5","vendors-node_modules_core-js_modules_es_parse-int_js-node_modules_core-js_modules_es_promise_js"], () => (__webpack_exec__("./assets/custom.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiY3VzdG9tLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7O0FBQUEsSUFBTUEsSUFBSSxHQUFHQyxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsWUFBeEIsQ0FBYjs7QUFDQSxJQUFJRixJQUFKLEVBQVU7QUFDTkEsRUFBQUEsSUFBSSxDQUFDRyxnQkFBTCxDQUFzQixPQUF0QixFQUErQixVQUFBQyxDQUFDLEVBQUc7QUFDL0IsUUFBSUEsQ0FBQyxDQUFDQyxNQUFGLENBQVNDLFNBQVQsS0FBdUIsNEJBQTNCLEVBQXlEO0FBQ3JELFVBQUlDLE9BQU8sQ0FBQyxlQUFELENBQVgsRUFBOEI7QUFDMUIsWUFBTUMsRUFBRSxHQUFHQyxRQUFRLENBQUNMLENBQUMsQ0FBQ0MsTUFBRixDQUFTSyxZQUFULENBQXNCLFNBQXRCLENBQUQsQ0FBbkI7O0FBQ0EsWUFBR0YsRUFBSCxFQUFPO0FBQ0hHLFVBQUFBLEtBQUssQ0FBQyxtQkFBaUJILEVBQWxCLEVBQXFCO0FBQ3RCSSxZQUFBQSxNQUFNLEVBQUU7QUFEYyxXQUFyQixDQUFMLENBRUdDLElBRkgsQ0FFUSxVQUFBQyxHQUFHO0FBQUEsbUJBQUlDLE1BQU0sQ0FBQ0MsUUFBUCxDQUFnQkMsTUFBaEIsRUFBSjtBQUFBLFdBRlg7QUFHSCxTQUpELE1BSU87QUFDSEMsVUFBQUEsS0FBSyxDQUFDLGtCQUFELENBQUw7QUFDSDtBQUNKLE9BVEQsTUFTTztBQUNILGVBQU8sS0FBUDtBQUNIO0FBQ0o7QUFDSixHQWZEO0FBZ0JIIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2N1c3RvbS5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCB1c2VyID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3VzZXJzX2xpc3QnKTtcclxuaWYgKHVzZXIpIHtcclxuICAgIHVzZXIuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBlID0+e1xyXG4gICAgICAgIGlmIChlLnRhcmdldC5jbGFzc05hbWUgPT09ICdidG4gYnRuLWRhbmdlciBkZWxldGUtdXNlcicpIHtcclxuICAgICAgICAgICAgaWYgKGNvbmZpcm0oJ0FyZSB5b3Ugc3VyZT8nKSkge1xyXG4gICAgICAgICAgICAgICAgY29uc3QgaWQgPSBwYXJzZUludChlLnRhcmdldC5nZXRBdHRyaWJ1dGUoJ2RhdGEtaWQnKSk7XHJcbiAgICAgICAgICAgICAgICBpZihpZCkge1xyXG4gICAgICAgICAgICAgICAgICAgIGZldGNoKCcvdXNlcnMvZGVsZXRlLycraWQse1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBtZXRob2Q6ICdHRVQnXHJcbiAgICAgICAgICAgICAgICAgICAgfSkudGhlbihyZXMgPT4gd2luZG93LmxvY2F0aW9uLnJlbG9hZCgpKTtcclxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgYWxlcnQoJ05vIGRhdGEgaWQgZm91bmQnKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgIH0pO1xyXG59Il0sIm5hbWVzIjpbInVzZXIiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwiYWRkRXZlbnRMaXN0ZW5lciIsImUiLCJ0YXJnZXQiLCJjbGFzc05hbWUiLCJjb25maXJtIiwiaWQiLCJwYXJzZUludCIsImdldEF0dHJpYnV0ZSIsImZldGNoIiwibWV0aG9kIiwidGhlbiIsInJlcyIsIndpbmRvdyIsImxvY2F0aW9uIiwicmVsb2FkIiwiYWxlcnQiXSwic291cmNlUm9vdCI6IiJ9