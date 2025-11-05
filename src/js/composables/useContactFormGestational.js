import useContactForm from '#/useContactForm.js'
import useModal from '#/useModal.js'

const { Modal } = useModal()
const modal = new Modal()


const fieldsData = {
  en: {
    modalHeading: 'Register for the <em>Life!</em> program',
    fields: {
      first_name: {
        label: 'First name',
      },
      last_name: {
        label: 'Last name',
      },
      email: {
        label: 'Email',
        type: 'email',
      },
      phone: {
        label: 'Mobile Phone',
        validation_macro: 'phone',
      },
      currently_gdm: {
        label: 'Are you currently pregnant with gestational diabetes?',
        type: 'buttons',
        options: {
          Yes: 'Yes',
          No: 'No',
        },
        validation: {
          message_required: 'Please indicate whether you are pregnant with GDM',
        },
      },
      due_date: {
        label: 'What is your due date?',
        type: 'date',
        validation: {
          message_required: 'Please select a date',
        },
        requiredFunc: (field) => field.form.fields.currently_gdm.val === 'Yes',
      },
      heard_about_via: {
        label: 'How did you hear about us?',
        type: 'select',
        options: {
          '': 'Please select...',
          'NDSS email': 'NDSS email',
          'Maternal Child Health': 'Maternal Child Health',
          'GDM Flyer': 'GDM Flyer',
          'GDM Brochure': 'GDM Brochure',
          'Hospital': 'Hospital',
          'GP': 'GP',
          'Google Search': 'Google Search',
          'Word of Mouth': 'Word of Mouth',
          'Health Professional': 'Health Professional',
          'Other': 'Other',
        },
      },
      consent: {
        label: 'I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to contact me regarding the <em>Life!</em> program and for any personal information collected to be used for necessary <em>Life!</em> program administrative operations.',
      },
    },
    submitButtonText: 'Submit details',
    returnToSiteButtonText: 'Return to Site',
  },
  vi: {
    modalHeading: 'Đăng ký thưộc tế cho chương trình',
    fields: {
      first_name: {
        label: 'Tên',
      },
      last_name: {
        label: 'Họ',
      },
      email: {
        label: 'Địa chỉ email',
        type: 'email',
      },
      phone: {
        label: 'Số điện thoại',
        validation_macro: 'phone',
      },
      currently_gdm: {
        label: 'Hiện bạn có đang mang thai và bị tiểu đường thai kỳ không?',
        type: 'buttons',
        options: {
          Yes: 'Có',
          No: 'Không',
        },
        validation: {
          message_required: 'Vui lòng cho biết bạn có thai với GDM hay không',
        },
      },
      due_date: {
        label: 'Ngày dự sinh của bạn là ngày mấy?',
        type: 'date',
        validation: {
          message_required: 'Vui lòng chọn một ngày',
        },
        requiredFunc: (field) => field.form.fields.currently_gdm.val === 'Yes',
      },
      heard_about_via: {
        label: 'Bạn đã nghe về chúng tôi từ ở đâu?',
        type: 'select',
        options: {
          '': 'Vui lòng chọn...',
          'NDSS email': 'Qua email NDSS',
          'Maternal Child Health': 'Chăm sóc sức khỏe mẫu nhi',
          'GDM Flyer': 'Tờ rơi về bệnh tiểu đường sau thai kỳ',
          'GDM Brochure': 'Tờ thông tin về bệnh tiểu đường sau thai kỳ',
          'Hospital': 'bệnh viện',
          'GP': 'bác sĩ gia đình',
          'Google Search': 'tìm kiếm từ Google',
          'Word of Mouth': 'Truyền miệng',
          'Health Professional': 'Chuyên viên Y Tế',
          'Other': 'chỗ khác',
        },
      },
      Do_you_need_an_interpreter__c: {
        label: 'Bạn có cẫn thông dịch viên không?',
        type: 'buttons',
        options: {
          Yes: 'Có',
          No: 'Không',
        },
        validation: {
          message_required: 'Vui lòng cho biết bạn có cần thông dịch viên hay không',
        },
      },
      Vietnamese_woman__c: {
        label: 'Tôi là một phụ nữ Việt Nam',
        validation: {
          message_required: 'Vui lòng đánh dấu vào ô trên',
        },
      },
      Program_to_be_deliver_Vietnamese__c: {
        label: 'Bạn có cần chương trình được cung cấp bằng tiếng Việt không?',
        type: 'buttons',
        options: {
          Yes: 'Có',
          No: 'Không',
        },
        validation: {
          message_required: 'Vui lòng chọn có hoặc không',
        },
      },
      consent: {
        label: 'Tôi đồng ý cho nhân viên của Diabetes Victoria từ chương trình <em>Life!</em> Program liên hệ với tôi về chương trình này và cho bất kỳ thông tin cá nhân nào được thu thập để sử dụng cho các hoạt động quản trị của chương trình <em>Life!</em>',
        validation: {
          message_required: 'xin vui lòng đồng ý',
        },
      },
    },
    submitButtonText: 'Gửi thông tin',
    returnToSiteButtonText: 'Trở lại trang chủ',
  },
}

const { ContactForm } = useContactForm()

class ContactFormGestational extends ContactForm {
  constructor(lang) {
    // Default to 'en' if lang is invalid or undefined
    const validLang = (lang && fieldsData[lang]) ? lang : 'en'
    const data = fieldsData[validLang]
    if (!data || !data.fields) {
      console.error('ContactFormGestational: Invalid language data for lang:', lang)
      throw new Error(`Invalid language configuration for: ${lang}`)
    }
    super(data.fields, validLang)
    this.data = data
    this._formId = 'gestational'
  }
}


export default () => ({
  ContactFormGestational,
  modal,
})

