img = $('img')[0]

newimg = new Image
newimg.onload = ->
  colorThief = new ColorThief()
  colors = colorThief.getPalette(newimg, 4)
  console.log colors
newimg.crossOrigin = "Anonymous"
newimg.src = img.src
$(img).replaceWith(newimg)
