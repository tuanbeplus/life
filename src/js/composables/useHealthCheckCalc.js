

const gender = (val) => {
  switch (val) {
    case 'Male': return 3
    case 'Female': return 0
  }
  console.error('Unknown `gender`: ' + val)
  return 0
}
const age = (val) => {
  switch (val) {
    case 'Under 35 years': return 0
    case '35 - 44 years': return 2
    case '45 - 54 years': return 4
    case '55 - 64 years': return 6
    case '65 years or over': return 8
  }
  console.error('Unknown `age`: ' + val)
  return 0
}
const background = (val) => {
  switch (val) {
    case 'Yes': return 2
    case 'No': return 0
  }
  console.error('Unknown `background`: ' + val)
  return 0
}
const birthplace = (val) => {
  switch (val) {
    case 'Other':
    case 'Australia':
      return 0
    case 'Asia (including the Indian sub-continent)':
    case 'Southern Europe':
    case 'Middle East':
    case 'North Africa':
      return 2
  }
  console.error('Unknown `birthplace`: ' + val)
  return 0
}
const diabetes = (val) => {
  switch (val) {
    case 'Yes': return 3
    case 'No': return 0
  }
  console.error('Unknown `diabetes`: ' + val)
  return 0
}
const pregnancy = (val) => {
  switch (val) {
    case 'Yes': return 6
    case 'No': return 0
  }
  console.error('Unknown `pregnancy`: ' + val)
  return 0
}
const blood_pressure_medication = (val) => {
  switch (val) {
    case 'Yes': return 2
    case 'No': return 0
  }
  console.error('Unknown `blood_pressure_medication`: ' + val)
  return 0
}
const smoker = (val) => {
  switch (val) {
    case 'Yes': return 2
    case 'No': return 0
  }
  console.error('Unknown `smoker`: ' + val)
  return 0
}
const vegetables = (val) => {
  switch (val) {
    case 'Everyday': return 0
    case 'Not everyday': return 1
  }
  console.error('Unknown `vegetables`: ' + val)
  return 0
}
const exercise = (val) => {
  switch (val) {
    case 'Yes': return 0
    case 'No': return 2
  }
  console.error('Unknown `exercise`: ' + val)
  return 0
}
const waist_range = (val) => {
  switch (val) {
    case '1': return 0
    case '2': return 4
    case '3': return 7
  }
  console.error('Unknown `waist_range`: ' + val)
  return 0
}


const scoreInc = (fieldName, val) => {
  switch (fieldName) {
    case 'gender': return gender(val)
    case 'age': return age(val)
    case 'background': return background(val)
    case 'birthplace': return birthplace(val)
    case 'diabetes': return diabetes(val)
    case 'pregnancy': return pregnancy(val)
    case 'blood_pressure_medication': return blood_pressure_medication(val)
    case 'smoker': return smoker(val)
    case 'vegetables': return vegetables(val)
    case 'exercise': return exercise(val)
    case 'waist_range': return waist_range(val)
    case 'diagnosis': return 0
  }
  console.error('Unknown field: `' + fieldName + '`')
  return 0
}


export default () => {
  return {
    scoreInc,
  }
}