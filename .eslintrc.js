module.exports = {
	env: {
		browser: true
		// es2021: true
	},
	extends: [
		'plugin:vue/recommended',
		// 'standard'
	],
	parser: "vue-eslint-parser",
	parserOptions: {
		ecmaVersion: 12,
		sourceType: 'module',
		parser: 'babel-eslint',
	},
	plugins: [
		'vue'
	],
	rules: {
		'no-console': 'off',
		"vue/html-indent": ["error", "tab"],
  		"indent": ["error", "tab"],
		'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
		"vue/component-definition-name-casing": ["error", "PascalCase"],
		'vue/attributes-order': 'off',
		"vue/multi-word-component-names": "off",
		'vue/html-self-closing': 'off',
		'vue/no-use-v-if-with-v-for': 'off',
		'vue/html-closing-bracket-newline': 'off',
		'vue/multiline-html-element-content-newline': 'off',
		'vue/singleline-html-element-content-newline': 'off',
		'vue/max-attributes-per-line': 'off',
		'vue/no-lone-template': 'off',
		'vue/no-unused-vars': 'off',
		'vue/no-v-html': 'off',
		'vue/require-default-prop': 'off',
		'vue/no-unused-components': 'off',
		'vue/require-prop-types': 'off',
		'vue/v-bind-style': 'off'
	}
}
