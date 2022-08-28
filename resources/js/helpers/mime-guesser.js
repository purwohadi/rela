import data from './data/mime.json'

const MIME_DEFAULT = {
  "extension": "bin",
  "kind_of_document": "Any kind of binary data",
  "mime_type": "application/octet-stream"
}

function getMime(ext) {
  let index = data.findIndex(item => item.extension == ext)
  if (index === -1) return MIME_DEFAULT

  return data[index]
}

export function guess(ext) {
  return getMime(ext)
}
