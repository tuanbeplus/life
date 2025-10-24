
const validationMessageGenericRequired = (lang) => {
  switch (lang) {
    case 'en':
      return 'This field is required'
    case 'vi':
      return 'Giá trị này là bắt buộc.'
    case 'ar':
      return 'هذه القيمة مطلوبة'
    case 'zh-Hans':
      return '必需的'
    case 'zh-Hant':
      return '必需的'
  }
}

const validationPhone = (lang) => {
  switch (lang) {
    case 'en':
      return {
        type_message: 'Please enter a 10 digit phone number. Numbers only.',
        message_maxlength_over: 'This value is too long. It should have 10 characters.',
        message_minlength_under: 'This value is too short. It should have 10 characters.',
      }
    case 'vi':
      return {
        type_message: 'Giá trị không hợp lệ. Vui lòng chỉ sử dụng số.',
        message_maxlength_over: 'Giá trị này quá dài. Phải có 10 ký tự.',
        message_minlength_under: 'Giá trị này quá ngắn. Phải có 10 ký tự.',
      }
    case 'ar':
      return {
        type_message: 'قيمة غير صالحة. الرجاء استخدام أرقام فقط',
        message_maxlength_over: 'هذه القيمة طويلة جدًا.  يجب أن يحتوي على 10 أحرف/رموز',
        message_minlength_under: 'هذه القيمة قصيرة جدًا.يجب أن تتألف من10أحرف/رموز',
      }
    case 'zh-Hans':
      return {
        type_message: '输入 10 位电话号码，不带空格',
        message_maxlength_over: '该值太长。它应该有 10 个字符。',
        message_minlength_under: '这个值太短了。它应该有 10 个字符。',
      }
    case 'zh-Hant':
      return {
        type_message: '輸入 10 位數字的電話號碼，不含空格',
        message_maxlength_over: '該值太長。它應該有 10 個字元。',
        message_minlength_under: '這個值太短了。它應該有 10 個字元。',
      }
  }
}
const validationPostcode = (lang) => {
  switch (lang) {
    case 'en':
      return {
        type_message: 'Please enter a 4 digit postcode. Numbers only.',
        message_maxlength_over: 'This value is too long. It should have 4 characters.',
        message_minlength_under: 'This value is too short. It should have 4 characters.',
      }
    case 'vi':
      return {
        type_message: 'Giá trị không hợp lệ. Vui lòng chỉ sử dụng số.',
        message_maxlength_over: 'Giá trị này quá dài. Phải có 4 ký tự.',
        message_minlength_under: 'Giá trị này quá ngắn. Phải có 4 ký tự.',
      }
    case 'ar':
      return {
        type_message: 'قيمة غير صالحة. الرجاء استخدام أرقام فقط',
        message_maxlength_over: 'هذه القيمة طويلة جدًا.  يجب أن يحتوي على 4 أحرف/رموز',
        message_minlength_under: 'هذه القيمة قصيرة جدًا.يجب أن تتألف من4أحرف/رموز',
      }
    case 'zh-Hans':
      return {
        type_message: '4 位数字邮政编码',
        message_maxlength_over: '4 位数字邮政编码',
        message_minlength_under: '4 位数字邮政编码',
      }
    case 'zh-Hant':
      return {
        type_message: '4 位數位郵遞區號',
        message_maxlength_over: '4 位數位郵遞區號',
        message_minlength_under: '4 位數位郵遞區號',
      }
  }
}
const validationEmail = (lang) => {
  switch (lang) {
    case 'en':
      return 'Please enter a valid email address'
    case 'vi':
      return 'Giá trị này phải là email hợp lệ.'
    case 'ar':
      return 'يجب أن تكون هذه القيمة عنوان بريد إلكتروني صالح'
    case 'zh-Hans':
      return '合法的邮件地址'
    case 'zh-Hant':
      return '合法的郵件地址'
  }
}

export {
  validationMessageGenericRequired,
  validationPostcode,
  validationEmail,
  validationPhone
}