module.exports = {
	plugins: [ 'stylelint-scss' ],
	ignoreFiles: [ 'dist/**/*' ],
	rules: {
		'at-rule-name-case': 'lower',
		'at-rule-name-space-after': 'always-single-line',
		'at-rule-no-unknown': null,
		'scss/at-rule-no-unknown': true,
		'block-no-empty': true,
		'color-no-invalid-hex': true,
		'comment-whitespace-inside': 'always',
		'comment-no-empty': true,
		'declaration-bang-space-after': 'never',
		'declaration-bang-space-before': 'always',
		'declaration-block-no-duplicate-properties': [
			true,
			{
				ignore: [ 'consecutive-duplicates-with-different-values' ],
			},
		],
		'declaration-block-no-shorthand-property-overrides': true,
		'declaration-colon-space-after': 'always-single-line',
		'declaration-colon-space-before': 'never',
		'declaration-colon-newline-after': 'always-multi-line',
		'declaration-empty-line-before': [
			'never',
			{
				ignore: [ 'after-comment', 'first-nested' ],
			},
		],
		'font-family-no-duplicate-names': true,
		'font-family-no-missing-generic-family-keyword': true,
		'function-calc-no-unspaced-operator': true,
		'function-linear-gradient-no-nonstandard-direction': true,
		'function-parentheses-space-inside': 'always-single-line',
		indentation: [ 'tab', { ignore: [ 'value', 'param' ] } ],
		'keyframe-declaration-no-important': true,
		'length-zero-no-unit': true,
		'max-empty-lines': 2,
		'max-line-length': 120,
		'max-nesting-depth': 6,
		'media-feature-colon-space-after': 'always',
		'media-feature-colon-space-before': 'never',
		'media-feature-name-case': 'lower',
		'media-feature-name-no-unknown': true,
		'media-feature-range-operator-space-after': 'always',
		'media-feature-range-operator-space-before': 'always',
		'media-feature-parentheses-space-inside': 'always',
		'media-query-list-comma-space-after': 'always-single-line',
		'media-query-list-comma-newline-before': 'never-multi-line',
		// 'no-descending-specificity': true,
		'no-duplicate-at-import-rules': true,
		'no-duplicate-selectors': true,
		'no-empty-source': true,
		'no-extra-semicolons': true,
		'number-leading-zero': 'always',
		'number-no-trailing-zeros': true,
		'property-no-unknown': [
			true,
			{ ignoreProperties: [ 'font-smoothing', 'font-smooth' ] },
		],
		'selector-attribute-operator-space-after': 'never',
		'selector-attribute-operator-space-before': 'never',
		'selector-attribute-quotes': 'always',
		'selector-list-comma-newline-after': 'always',
		'selector-list-comma-newline-before': 'never-multi-line',
		'selector-list-comma-space-after': 'always-single-line',
		'selector-list-comma-space-before': 'never',
		'selector-max-compound-selectors': 5,
		'selector-max-id': 0,
		'selector-max-type': 4,
		'selector-pseudo-class-case': 'lower',
		'selector-pseudo-class-no-unknown': true,
		'selector-pseudo-class-parentheses-space-inside': 'always',
		'selector-pseudo-element-no-unknown': true,
		'selector-type-no-unknown': true,
		'string-no-newline': true,
		'string-quotes': 'double',
		'unit-case': 'lower',
		'at-rule-no-vendor-prefix': true,
		'media-feature-name-no-vendor-prefix': true,
		'property-no-vendor-prefix': true,
		'unit-no-unknown': true,
		'value-no-vendor-prefix': true,
	},
};
