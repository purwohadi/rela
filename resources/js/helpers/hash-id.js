import Hashids from 'hashids'

function hex2String(hex) {
  var string = ''
  for (var i = 0; i < hex.length; i += 2) {
    string += String.fromCharCode(parseInt(hex.substr(i, 2), 16))
  }
  return string
}

export function encrypt(text) {
  const hashids = new Hashids(btoa(window.settings.appname), 5) // pad to length 10
  var hex = Buffer(text).toString('hex')
  return hashids.encodeHex(hex)
}

export function decrypt(text) {
  const hashids = new Hashids(btoa(window.settings.appname), 5) // pad to length 10
  return hex2String(hashids.decodeHex(text))
}
