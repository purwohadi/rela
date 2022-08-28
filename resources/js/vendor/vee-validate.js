import { extend } from 'vee-validate'
import * as rules from 'vee-validate/dist/rules'
import id from 'vee-validate/dist/locale/id'

// alpha, alpha_dash, alpha_num, alpha_spaces, between, confirmed, digits, dimensions, email,
// excluded, ext, image, integer, is, is_not, length, max, max_value, mimes, min, min_value,
// numeric, oneOf, regex, required, required_if, size
for (let rule in rules) {
  extend(rule, {
    // add the rule
    ...rules[rule],

    // add its message
    message: id.messages[rule]
  })
}

extend('maxDimension', {
  validate: (file, [width, height]) => {
    const validateImage = function (file, width, height) {
      const URL = window.URL || window.webkitURL
      const promise = new Promise(resolve => {
        const image = new Image()
        image.src = URL.createObjectURL(file)
        image.onerror = () => resolve({ valid: false })
        image.onload = () => resolve({
          valid: Number(image.width) <= Number(width) && (image.height) <= Number(height)// only change from official rule
        })
      })
      return promise
    }

    const isValid = validateImage(file, width, height)

    return isValid.then(result => {
      if (result.valid) {
        return true
      } else {
        return `Dimensi {_field_} harus ${width} pixels x ${height} pixels atau dibawahnya`
      }
    })
  }
})

extend('special', {
    validate: value => {
      var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
      return strongRegex.test(value) ? true : 'Password harus mengandung : 1 huruf besar, 1 huruf kecil, 1 angka, dan karakter spesial (Cth. @ , . _ & ? dll'
    }
});

extend("decimal", {
  validate: (value, { decimals = '*', separator = '.' } = {}) => {
    if (value === null || value === undefined || value === '') {
      return {
        valid: false
      };
    }
    if (Number(decimals) === 0) {
      return {
        valid: /^-?\d*$/.test(value),
      };
    }
    const regexPart = decimals === '*' ? '+' : `{1,${decimals}}`;
    const regex = new RegExp(`^[-+]?\\d*(\\${separator}\\d${regexPart})?([eE]{1}[-]?\\d+)?$`);

    return {
      valid: regex.test(value),
    };
  },
  message: 'Field harus berisikan nilai desimal (ex : 123.11)'
})

