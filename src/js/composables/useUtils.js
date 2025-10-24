

const eListen = ({ type = 'click', selector, callback, options, parent = document }) => {
  parent.addEventListener(
    type,
    e => {
      if (e.target.closest(selector)) {
        callback(e)
      }
    },
    options
  )
}

export default () => ({
  eListen,
})