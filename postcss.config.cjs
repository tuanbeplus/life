const clamp = (propName, val1, val2, unit, factor = 100) => {
  const valMin = val2 === null ? val1 / 2 : val1
  const valMax = val2 === null ? val1 : val2
  return {
    [propName]: `clamp(${valMin}${unit}, ${valMax * factor / 1440}vw, ${valMax}${unit})`,
  }
}

module.exports = {
  plugins: {
    'postcss-import': {},
    'postcss-nested': {},
    'postcss-mixins': {
      mixins: {
        clampRem(mixin, propName, val1, val2 = null) {
          return clamp(propName, val1, val2, 'rem', 1600)
        },
        clampPx(mixin, propName, val1, val2 = null) {
          return clamp(propName, val1, val2, 'px')
        },
        clampPxX(mixin, propName, val1, val2 = null) {
          return {
            ...clamp(propName + '-left', val1, val2, 'px'),
            ...clamp(propName + '-right', val1, val2, 'px'),
          }
        },
        clampPxY(mixin, propName, val1, val2 = null) {
          return {
            ...clamp(propName + '-top', val1, val2, 'px'),
            ...clamp(propName + '-bottom', val1, val2, 'px'),
          }
        },
      },
    },
    autoprefixer: {},
    'postcss-custom-media': {},
  },
}
