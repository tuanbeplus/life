import useDialog from '#/useDialog.js'



const { Dialog } = useDialog()


class DialogShare extends Dialog {
  constructor() {
    super()
  }
}

const dialogShare = new DialogShare()

export default () => ({
  dialogShare,
})