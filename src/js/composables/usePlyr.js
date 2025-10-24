

let _promise = null

function plyrPromise() {
  if (_promise === null) {
    _promise = new Promise((resolve, reject) => {
      const link = document.createElement('link')
      link.rel = 'stylesheet'
      link.href = 'https://cdn.plyr.io/3.7.8/plyr.css'
      document.head.appendChild(link)

      const script = document.createElement('script')
      script.src = 'https://cdn.plyr.io/3.7.8/plyr.js'
      script.onload = () => resolve(script)
      script.onerror = () => reject(new Error(`Failed to load plyr.js`))
      document.head.append(script)
    })
  }
  return _promise
}








export default () => ({
  plyrPromise,
})

