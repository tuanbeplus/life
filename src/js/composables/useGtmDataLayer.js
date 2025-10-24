const APP_ENV = __APP_ENV__


const gtmDataLayerPush = (data) => {
  if (window.dataLayer === undefined) {
    console.error('dataLayer is undefined')
    window.dataLayer = []
  }
  if (APP_ENV === 'dev') {
    // const { event, ...others } = data
    // console.log(' - ')
    // console.log('GTM : ', event)
    // for (const key in others) {
    //   console.log(key, others[key])
    // }
  } else {
    window.dataLayer.push(data)
  }
}

const gtmEvent = (event, data = {}) => {
  gtmDataLayerPush({
    'event': event,
    ...data,
  })
}


const langToSlug = lang => lang.toLowerCase().replace('-', '_')





export default () => ({
  // gtmDataLayerPush,
  gtmEvent,
  langToSlug,
})

