/*

StackBlur - a fast almost Gaussian Blur For Canvas

Version:    0.5
Author:     Mario Klingemann
Contact:    mario@quasimondo.com
Website:    http://www.quasimondo.com/StackBlurForCanvas
Twitter:    @quasimondo

In case you find this class useful - especially in commercial projects -
I am not totally unhappy for a small donation to my PayPal account
mario@quasimondo.de

Or support me on flattr: 
https://flattr.com/thing/72791/StackBlur-a-fast-almost-Gaussian-Blur-Effect-for-CanvasJavascript

Copyright (c) 2010 Mario Klingemann

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

var mul_table = [
        512,512,456,512,328,456,335,512,405,328,271,456,388,335,292,512,
        454,405,364,328,298,271,496,456,420,388,360,335,312,292,273,512,
        482,454,428,405,383,364,345,328,312,298,284,271,259,496,475,456,
        437,420,404,388,374,360,347,335,323,312,302,292,282,273,265,512,
        497,482,468,454,441,428,417,405,394,383,373,364,354,345,337,328,
        320,312,305,298,291,284,278,271,265,259,507,496,485,475,465,456,
        446,437,428,420,412,404,396,388,381,374,367,360,354,347,341,335,
        329,323,318,312,307,302,297,292,287,282,278,273,269,265,261,512,
        505,497,489,482,475,468,461,454,447,441,435,428,422,417,411,405,
        399,394,389,383,378,373,368,364,359,354,350,345,341,337,332,328,
        324,320,316,312,309,305,301,298,294,291,287,284,281,278,274,271,
        268,265,262,259,257,507,501,496,491,485,480,475,470,465,460,456,
        451,446,442,437,433,428,424,420,416,412,408,404,400,396,392,388,
        385,381,377,374,370,367,363,360,357,354,350,347,344,341,338,335,
        332,329,326,323,320,318,315,312,310,307,304,302,299,297,294,292,
        289,287,285,282,280,278,275,273,271,269,267,265,263,261,259];
        
   
var shg_table = [
         9, 11, 12, 13, 13, 14, 14, 15, 15, 15, 15, 16, 16, 16, 16, 17, 
        17, 17, 17, 17, 17, 17, 18, 18, 18, 18, 18, 18, 18, 18, 18, 19, 
        19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 20, 20, 20,
        20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 21,
        21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21,
        21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 22, 22, 22, 22, 22, 22, 
        22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22,
        22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 23, 
        23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23,
        23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23,
        23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 
        23, 23, 23, 23, 23, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 
        24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24 ];

function stackBlurImage( image, canvas, radius, blurAlphaChannel )
{
            
    var img = image;
    var w = img.width;
    var h = img.height;
       
    var canvas = canvas;
      
    canvas.style.width  = w + "px";
    canvas.style.height = h + "px";
    canvas.width = w;
    canvas.height = h;
    
    var context = canvas.getContext("2d");
    context.clearRect( 0, 0, w, h );
    context.drawImage( img, 0, 0, w, h );

    if ( isNaN(radius) || radius < 1 ) return;
    
    if ( blurAlphaChannel )
        stackBlurCanvasRGBA( canvas, 0, 0, w, h, radius );
    else 
        stackBlurCanvasRGB( canvas, 0, 0, w, h, radius );
}


function stackBlurCanvasRGBA( canvas, top_x, top_y, width, height, radius )
{
    if ( isNaN(radius) || radius < 1 ) return;
    radius |= 0;
    
    var canvas  = canvas;
    var context = canvas.getContext("2d");
    var imageData;
    
    try {
      try {
        imageData = context.getImageData( top_x, top_y, width, height );
      } catch(e) {
      
        // NOTE: this part is supposedly only needed if you want to work with local files
        // so it might be okay to remove the whole try/catch block and just use
        // imageData = context.getImageData( top_x, top_y, width, height );
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead");
            imageData = context.getImageData( top_x, top_y, width, height );
        } catch(e) {
            alert("Cannot access local image");
            throw new Error("unable to access local image data: " + e);
            return;
        }
      }
    } catch(e) {
      alert("Cannot access image");
      throw new Error("unable to access image data: " + e);
    }
            
    var pixels = imageData.data;
            
    var x, y, i, p, yp, yi, yw, r_sum, g_sum, b_sum, a_sum, 
    r_out_sum, g_out_sum, b_out_sum, a_out_sum,
    r_in_sum, g_in_sum, b_in_sum, a_in_sum, 
    pr, pg, pb, pa, rbs;
            
    var div = radius + radius + 1;
    var w4 = width << 2;
    var widthMinus1  = width - 1;
    var heightMinus1 = height - 1;
    var radiusPlus1  = radius + 1;
    var sumFactor = radiusPlus1 * ( radiusPlus1 + 1 ) / 2;
    
    var stackStart = new BlurStack();
    var stack = stackStart;
    for ( i = 1; i < div; i++ )
    {
        stack = stack.next = new BlurStack();
        if ( i == radiusPlus1 ) var stackEnd = stack;
    }
    stack.next = stackStart;
    var stackIn = null;
    var stackOut = null;
    
    yw = yi = 0;
    
    var mul_sum = mul_table[radius];
    var shg_sum = shg_table[radius];
    
    for ( y = 0; y < height; y++ )
    {
        r_in_sum = g_in_sum = b_in_sum = a_in_sum = r_sum = g_sum = b_sum = a_sum = 0;
        
        r_out_sum = radiusPlus1 * ( pr = pixels[yi] );
        g_out_sum = radiusPlus1 * ( pg = pixels[yi+1] );
        b_out_sum = radiusPlus1 * ( pb = pixels[yi+2] );
        a_out_sum = radiusPlus1 * ( pa = pixels[yi+3] );
        
        r_sum += sumFactor * pr;
        g_sum += sumFactor * pg;
        b_sum += sumFactor * pb;
        a_sum += sumFactor * pa;
        
        stack = stackStart;
        
        for( i = 0; i < radiusPlus1; i++ )
        {
            stack.r = pr;
            stack.g = pg;
            stack.b = pb;
            stack.a = pa;
            stack = stack.next;
        }
        
        for( i = 1; i < radiusPlus1; i++ )
        {
            p = yi + (( widthMinus1 < i ? widthMinus1 : i ) << 2 );
            r_sum += ( stack.r = ( pr = pixels[p])) * ( rbs = radiusPlus1 - i );
            g_sum += ( stack.g = ( pg = pixels[p+1])) * rbs;
            b_sum += ( stack.b = ( pb = pixels[p+2])) * rbs;
            a_sum += ( stack.a = ( pa = pixels[p+3])) * rbs;
            
            r_in_sum += pr;
            g_in_sum += pg;
            b_in_sum += pb;
            a_in_sum += pa;
            
            stack = stack.next;
        }
        
        
        stackIn = stackStart;
        stackOut = stackEnd;
        for ( x = 0; x < width; x++ )
        {
            pixels[yi+3] = pa = (a_sum * mul_sum) >> shg_sum;
            if ( pa != 0 )
            {
                pa = 255 / pa;
                pixels[yi]   = ((r_sum * mul_sum) >> shg_sum) * pa;
                pixels[yi+1] = ((g_sum * mul_sum) >> shg_sum) * pa;
                pixels[yi+2] = ((b_sum * mul_sum) >> shg_sum) * pa;
            } else {
                pixels[yi] = pixels[yi+1] = pixels[yi+2] = 0;
            }
            
            r_sum -= r_out_sum;
            g_sum -= g_out_sum;
            b_sum -= b_out_sum;
            a_sum -= a_out_sum;
            
            r_out_sum -= stackIn.r;
            g_out_sum -= stackIn.g;
            b_out_sum -= stackIn.b;
            a_out_sum -= stackIn.a;
            
            p =  ( yw + ( ( p = x + radius + 1 ) < widthMinus1 ? p : widthMinus1 ) ) << 2;
            
            r_in_sum += ( stackIn.r = pixels[p]);
            g_in_sum += ( stackIn.g = pixels[p+1]);
            b_in_sum += ( stackIn.b = pixels[p+2]);
            a_in_sum += ( stackIn.a = pixels[p+3]);
            
            r_sum += r_in_sum;
            g_sum += g_in_sum;
            b_sum += b_in_sum;
            a_sum += a_in_sum;
            
            stackIn = stackIn.next;
            
            r_out_sum += ( pr = stackOut.r );
            g_out_sum += ( pg = stackOut.g );
            b_out_sum += ( pb = stackOut.b );
            a_out_sum += ( pa = stackOut.a );
            
            r_in_sum -= pr;
            g_in_sum -= pg;
            b_in_sum -= pb;
            a_in_sum -= pa;
            
            stackOut = stackOut.next;

            yi += 4;
        }
        yw += width;
    }

    
    for ( x = 0; x < width; x++ )
    {
        g_in_sum = b_in_sum = a_in_sum = r_in_sum = g_sum = b_sum = a_sum = r_sum = 0;
        
        yi = x << 2;
        r_out_sum = radiusPlus1 * ( pr = pixels[yi]);
        g_out_sum = radiusPlus1 * ( pg = pixels[yi+1]);
        b_out_sum = radiusPlus1 * ( pb = pixels[yi+2]);
        a_out_sum = radiusPlus1 * ( pa = pixels[yi+3]);
        
        r_sum += sumFactor * pr;
        g_sum += sumFactor * pg;
        b_sum += sumFactor * pb;
        a_sum += sumFactor * pa;
        
        stack = stackStart;
        
        for( i = 0; i < radiusPlus1; i++ )
        {
            stack.r = pr;
            stack.g = pg;
            stack.b = pb;
            stack.a = pa;
            stack = stack.next;
        }
        
        yp = width;
        
        for( i = 1; i <= radius; i++ )
        {
            yi = ( yp + x ) << 2;
            
            r_sum += ( stack.r = ( pr = pixels[yi])) * ( rbs = radiusPlus1 - i );
            g_sum += ( stack.g = ( pg = pixels[yi+1])) * rbs;
            b_sum += ( stack.b = ( pb = pixels[yi+2])) * rbs;
            a_sum += ( stack.a = ( pa = pixels[yi+3])) * rbs;
           
            r_in_sum += pr;
            g_in_sum += pg;
            b_in_sum += pb;
            a_in_sum += pa;
            
            stack = stack.next;
        
            if( i < heightMinus1 )
            {
                yp += width;
            }
        }
        
        yi = x;
        stackIn = stackStart;
        stackOut = stackEnd;
        for ( y = 0; y < height; y++ )
        {
            p = yi << 2;
            pixels[p+3] = pa = (a_sum * mul_sum) >> shg_sum;
            if ( pa > 0 )
            {
                pa = 255 / pa;
                pixels[p]   = ((r_sum * mul_sum) >> shg_sum ) * pa;
                pixels[p+1] = ((g_sum * mul_sum) >> shg_sum ) * pa;
                pixels[p+2] = ((b_sum * mul_sum) >> shg_sum ) * pa;
            } else {
                pixels[p] = pixels[p+1] = pixels[p+2] = 0;
            }
            
            r_sum -= r_out_sum;
            g_sum -= g_out_sum;
            b_sum -= b_out_sum;
            a_sum -= a_out_sum;
           
            r_out_sum -= stackIn.r;
            g_out_sum -= stackIn.g;
            b_out_sum -= stackIn.b;
            a_out_sum -= stackIn.a;
            
            p = ( x + (( ( p = y + radiusPlus1) < heightMinus1 ? p : heightMinus1 ) * width )) << 2;
            
            r_sum += ( r_in_sum += ( stackIn.r = pixels[p]));
            g_sum += ( g_in_sum += ( stackIn.g = pixels[p+1]));
            b_sum += ( b_in_sum += ( stackIn.b = pixels[p+2]));
            a_sum += ( a_in_sum += ( stackIn.a = pixels[p+3]));
           
            stackIn = stackIn.next;
            
            r_out_sum += ( pr = stackOut.r );
            g_out_sum += ( pg = stackOut.g );
            b_out_sum += ( pb = stackOut.b );
            a_out_sum += ( pa = stackOut.a );
            
            r_in_sum -= pr;
            g_in_sum -= pg;
            b_in_sum -= pb;
            a_in_sum -= pa;
            
            stackOut = stackOut.next;
            
            yi += width;
        }
    }
    
    context.putImageData( imageData, top_x, top_y );
    
}


function stackBlurCanvasRGB( canvas, top_x, top_y, width, height, radius )
{
    if ( isNaN(radius) || radius < 1 ) return;
    radius |= 0;
    
    var canvas  = canvas;
    var context = canvas.getContext("2d");
    var imageData;
    
    try {
      try {
        imageData = context.getImageData( top_x, top_y, width, height );
      } catch(e) {
      
        // NOTE: this part is supposedly only needed if you want to work with local files
        // so it might be okay to remove the whole try/catch block and just use
        // imageData = context.getImageData( top_x, top_y, width, height );
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead");
            imageData = context.getImageData( top_x, top_y, width, height );
        } catch(e) {
            alert("Cannot access local image");
            throw new Error("unable to access local image data: " + e);
            return;
        }
      }
    } catch(e) {
      alert("Cannot access image");
      throw new Error("unable to access image data: " + e);
    }
            
    var pixels = imageData.data;
            
    var x, y, i, p, yp, yi, yw, r_sum, g_sum, b_sum,
    r_out_sum, g_out_sum, b_out_sum,
    r_in_sum, g_in_sum, b_in_sum,
    pr, pg, pb, rbs;
            
    var div = radius + radius + 1;
    var w4 = width << 2;
    var widthMinus1  = width - 1;
    var heightMinus1 = height - 1;
    var radiusPlus1  = radius + 1;
    var sumFactor = radiusPlus1 * ( radiusPlus1 + 1 ) / 2;
    
    var stackStart = new BlurStack();
    var stack = stackStart;
    for ( i = 1; i < div; i++ )
    {
        stack = stack.next = new BlurStack();
        if ( i == radiusPlus1 ) var stackEnd = stack;
    }
    stack.next = stackStart;
    var stackIn = null;
    var stackOut = null;
    
    yw = yi = 0;
    
    var mul_sum = mul_table[radius];
    var shg_sum = shg_table[radius];
    
    for ( y = 0; y < height; y++ )
    {
        r_in_sum = g_in_sum = b_in_sum = r_sum = g_sum = b_sum = 0;
        
        r_out_sum = radiusPlus1 * ( pr = pixels[yi] );
        g_out_sum = radiusPlus1 * ( pg = pixels[yi+1] );
        b_out_sum = radiusPlus1 * ( pb = pixels[yi+2] );
        
        r_sum += sumFactor * pr;
        g_sum += sumFactor * pg;
        b_sum += sumFactor * pb;
        
        stack = stackStart;
        
        for( i = 0; i < radiusPlus1; i++ )
        {
            stack.r = pr;
            stack.g = pg;
            stack.b = pb;
            stack = stack.next;
        }
        
        for( i = 1; i < radiusPlus1; i++ )
        {
            p = yi + (( widthMinus1 < i ? widthMinus1 : i ) << 2 );
            r_sum += ( stack.r = ( pr = pixels[p])) * ( rbs = radiusPlus1 - i );
            g_sum += ( stack.g = ( pg = pixels[p+1])) * rbs;
            b_sum += ( stack.b = ( pb = pixels[p+2])) * rbs;
            
            r_in_sum += pr;
            g_in_sum += pg;
            b_in_sum += pb;
            
            stack = stack.next;
        }
        
        
        stackIn = stackStart;
        stackOut = stackEnd;
        for ( x = 0; x < width; x++ )
        {
            pixels[yi]   = (r_sum * mul_sum) >> shg_sum;
            pixels[yi+1] = (g_sum * mul_sum) >> shg_sum;
            pixels[yi+2] = (b_sum * mul_sum) >> shg_sum;
            
            r_sum -= r_out_sum;
            g_sum -= g_out_sum;
            b_sum -= b_out_sum;
            
            r_out_sum -= stackIn.r;
            g_out_sum -= stackIn.g;
            b_out_sum -= stackIn.b;
            
            p =  ( yw + ( ( p = x + radius + 1 ) < widthMinus1 ? p : widthMinus1 ) ) << 2;
            
            r_in_sum += ( stackIn.r = pixels[p]);
            g_in_sum += ( stackIn.g = pixels[p+1]);
            b_in_sum += ( stackIn.b = pixels[p+2]);
            
            r_sum += r_in_sum;
            g_sum += g_in_sum;
            b_sum += b_in_sum;
            
            stackIn = stackIn.next;
            
            r_out_sum += ( pr = stackOut.r );
            g_out_sum += ( pg = stackOut.g );
            b_out_sum += ( pb = stackOut.b );
            
            r_in_sum -= pr;
            g_in_sum -= pg;
            b_in_sum -= pb;
            
            stackOut = stackOut.next;

            yi += 4;
        }
        yw += width;
    }

    
    for ( x = 0; x < width; x++ )
    {
        g_in_sum = b_in_sum = r_in_sum = g_sum = b_sum = r_sum = 0;
        
        yi = x << 2;
        r_out_sum = radiusPlus1 * ( pr = pixels[yi]);
        g_out_sum = radiusPlus1 * ( pg = pixels[yi+1]);
        b_out_sum = radiusPlus1 * ( pb = pixels[yi+2]);
        
        r_sum += sumFactor * pr;
        g_sum += sumFactor * pg;
        b_sum += sumFactor * pb;
        
        stack = stackStart;
        
        for( i = 0; i < radiusPlus1; i++ )
        {
            stack.r = pr;
            stack.g = pg;
            stack.b = pb;
            stack = stack.next;
        }
        
        yp = width;
        
        for( i = 1; i <= radius; i++ )
        {
            yi = ( yp + x ) << 2;
            
            r_sum += ( stack.r = ( pr = pixels[yi])) * ( rbs = radiusPlus1 - i );
            g_sum += ( stack.g = ( pg = pixels[yi+1])) * rbs;
            b_sum += ( stack.b = ( pb = pixels[yi+2])) * rbs;
            
            r_in_sum += pr;
            g_in_sum += pg;
            b_in_sum += pb;
            
            stack = stack.next;
        
            if( i < heightMinus1 )
            {
                yp += width;
            }
        }
        
        yi = x;
        stackIn = stackStart;
        stackOut = stackEnd;
        for ( y = 0; y < height; y++ )
        {
            p = yi << 2;
            pixels[p]   = (r_sum * mul_sum) >> shg_sum;
            pixels[p+1] = (g_sum * mul_sum) >> shg_sum;
            pixels[p+2] = (b_sum * mul_sum) >> shg_sum;
            
            r_sum -= r_out_sum;
            g_sum -= g_out_sum;
            b_sum -= b_out_sum;
            
            r_out_sum -= stackIn.r;
            g_out_sum -= stackIn.g;
            b_out_sum -= stackIn.b;
            
            p = ( x + (( ( p = y + radiusPlus1) < heightMinus1 ? p : heightMinus1 ) * width )) << 2;
            
            r_sum += ( r_in_sum += ( stackIn.r = pixels[p]));
            g_sum += ( g_in_sum += ( stackIn.g = pixels[p+1]));
            b_sum += ( b_in_sum += ( stackIn.b = pixels[p+2]));
            
            stackIn = stackIn.next;
            
            r_out_sum += ( pr = stackOut.r );
            g_out_sum += ( pg = stackOut.g );
            b_out_sum += ( pb = stackOut.b );
            
            r_in_sum -= pr;
            g_in_sum -= pg;
            b_in_sum -= pb;
            
            stackOut = stackOut.next;
            
            yi += width;
        }
    }
    
    context.putImageData( imageData, top_x, top_y );
    
}

function BlurStack()
{
    this.r = 0;
    this.g = 0;
    this.b = 0;
    this.a = 0;
    this.next = null;
}
(function($) {

  // breakpoint vars
  var large_break = 980,
      medium_break = 740,
      small_break = 480;

  // menu
  $('.main-nav').on('focus, click', '.has-dropdown > a', function(e) {
    e.preventDefault();

    $(this).parent('li').toggleClass('active');
  }).on('mouseout', function() {
    $(this).parent('li').removeClass('active');
  });

  $('.mobile-menu').on('click', '.has-dropdown > a', function(e) {
    e.preventDefault();
    
    var $this = $(this);

    if ($this.parent('li').hasClass('active')) {
      $this.parent('li').removeClass('active');
      close_mobile_accordion($this.siblings('ul'));
    } else {
      close_mobile_accordion($mobile_menu.find('.has-dropdown.active ul'));
      $mobile_menu.find('.has-dropdown').removeClass('active');
      $this.parent('li').addClass('active');
      open_mobile_accordion($this.siblings('ul'));
    }
  });

  // move menu to mobile menu for tablet & down
  if ( Modernizr.mq('only screen and (max-width:' + medium_break + 'px)') ) {
    console.log("medium screen or down");
    // add main nav to mobile menu
    var $mobile_menu = $('.mobile-menu'),
        $main_nav = $('.main-menu').children('li');

    $mobile_menu.append($main_nav);

    $('.mobile-menu-trigger').on('click', function(e) {
      e.preventDefault();
      if ( $(this).hasClass('active') ) {
        $(this).removeClass('active');
        close_mobile_menu();
      } else {
        $(this).addClass('active');
        open_mobile_menu();
      }
    });
  }

  // mobile menu fn's3
  function open_mobile_menu() {
    $('body').addClass('menu-open');

    var $container = $('.container'),
        $menu_items = $('.mobile-menu').children('li');

    // set up li's to be off screen
    TweenLite.set($menu_items, {
      x: 250,
      opacity: 0.5
    });

    // animate container to the left
    TweenLite.to($container, 0.3, {
      x: -250,
      ease: Power3.easeOut
    });

    // stagger animation of menu items
    for (var i = 0; i < $menu_items.length; i++) {
      TweenLite.to($menu_items[i], 0.2, {
        x: 0,
        opacity: 1,
        delay: 0.075*i + 0.05
      });
    }
  }

  function close_mobile_menu() {
    $('body').removeClass('menu-open');
    TweenLite.to($('.container'), 0.3, {
      x: 0,
      ease: Power3.easeOut
    });
  }

  function open_mobile_accordion(ul) {
    var $menu_items = ul.children('li'),
        height = $menu_items.length * 31 + 8;

    TweenLite.set($menu_items, {
      x: 150,
      opacity: 0.5
    });

    TweenLite.to(ul, 0.25, {
      height: height,
      ease: Power3.easeOut
    });

    for (var i = 0; i < $menu_items.length; i++) {
      TweenLite.to($menu_items[i], 0.2, {
        x: 0,
        opacity: 1,
        delay: 0.06*i + 0.025
      });
    }
  }

  function close_mobile_accordion(ul) {
    TweenLite.to(ul, 0.25, {
      height: 0,
      ease: Power3.easeOut
    });
  }

  // forms
  $('.input-wrapper').on('focus', 'input, textarea', function() {
    $(this).parent('.input-wrapper').addClass('focused');
  }).on('blur', 'input, textarea', function() {
    $(this).parent('.input-wrapper').removeClass('focused');
  });

  $('.select-box').on('change', 'select', function(e) {
    if (this.value) {
      $(this).parent('.select-box').addClass('selected');
    } else {
      $(this).parent('.select-box').removeClass('selected');
    }
  });

  $('.date-input input').datepicker({
    autoclose: true,
    format: "mm/dd/yyyy"
  }).on('changeDate', function() {
    $(this).parent().addClass('selected');
  });

  $('.input-switch').on('change', function() {
    var switch_id = $(this).data('switchto'),
        $targets = $(this).parents('.row').find('.switch-target');

    $targets.removeClass('active').filter('#' + switch_id).addClass('active');
  });

  // file upload
  var brief_uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',

    browse_button : $('.add-files')[0], // you can pass in id...
    container: $('.uploaded-files')[0], // ... or DOM Element itself

    url : "/examples/upload",

    filters : {
        max_file_size : '50mb',
        mime_types: [
            {title : "Image files", extensions : "jpg,gif,png"},
            {title : "Zip files", extensions : "zip"}
        ]
    },

    // Flash settings
    flash_swf_url : '/bower_components/plupload/js/Moxie.swf',

    // Silverlight settings
    silverlight_xap_url : '/bower_components/plupload/js/Moxie.xap',


    init: {
        PostInit: function() {
            //document.getElementById('filelist').innerHTML = '';
            $('.upload').on('click', function() {
              brief_uploader.start();
              return false;
            });
        },

        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
              $('.uploaded-files').append('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ')</div>');
                //document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
            });
        },

        UploadProgress: function(up, file) {
          console.log("percent complete:", file.percent);
        },

        Error: function(up, err) {
          console.log("error:", err.code, err.message);
        }
    }
  });

  brief_uploader.init();

  // monkee quote form
  if ($('.request-quote-form').length > 0) {

    // attach validation
    $('.request-quote-form').validationEngine('attach', {
      showArrow: false,
      binded: false,
      promptPosition: "bottomLeft",
      'custom_error_messages' : {
        'required': { 'message': 'Oops, looks like you forgot to add this field' },
        '#url' : {
          'custom[url]': { 'message': 'That doesn\'t look like the URLs we\'re used to.' }
        }
      }
    });

    // on blur, validate and set opacity
    $('.request-quote-form').on('blur', '.form-part1 input', function() {
      var $this = $(this),
          $steps = $('.request-quote-form').find('.monkee-step'),
          $monkee = $('.request-quote-form').find('.monkee'),
          is_valid = !$this.validationEngine('validate');

      // test if parent should be marked complete
      if (is_valid) {
        if ( $this.parent().is(':last-child') ) $this.parents('.form-step').addClass('complete');
      } else {
        $this.parents('.form-step').removeClass('complete');
      }

      // change opacity of monkee
      var complete_steps = $steps.filter('.complete').length;
      if (complete_steps > 0) {
        var opacity = 1 - complete_steps/$steps.length;
        $monkee.children('.dark-monkee').css('opacity', opacity);
        console.log("opacity should be", opacity);
      }
      // speech bubble
      if ( complete_steps === $steps.length ) {
        $monkee.addClass('speak');
      } else {
        $monkee.removeClass('speak');
      }
    });
  }

  var PortfolioSlider = function(el) {
    this.$el = $(el);
    this.$screenContainer = this.$el.find('.screens');
    this.$screens = this.$screenContainer.children('.screen');
    this.$thumbs = this.$el.find('.thumbs');
    this.ratios = {
      desktop: 0.727,
      tablet: 1.328,
      phone: 2.08
    };
    this.margin = 160;
    this.width = this.$screenContainer.width();
    this.thumbRatio = 0.2;
    this.activeSlide = 'desktop';
    this.siteName = this.$el.data('site');
  };

  PortfolioSlider.prototype._getX = function(pos, slide, ratio) {
    // get the x-translate value
    var abs_value = ( this.width - ($(slide).width() * ratio) ) / 2;
    if ( pos == 'left' ) {
      return -abs_value;
    } else {
      return abs_value;
    }
  };

  PortfolioSlider.prototype._moveSlide = function(el, pos, ratio) {
    var thumbRatio = ratio ? ratio : this.thumbRatio,
        scale = pos == 'active' ? 1 : thumbRatio,
        x = pos == 'active' ? 0 : this._getX(pos, el, thumbRatio);

    console.log("moving slide", el, "to position", pos);

    TweenLite.to(el, 0.5, {
      scale: scale,
      x: x
    });
  };

  PortfolioSlider.prototype.transitionSlides = function(direction) {
    // if it's the first transition, remove the class "initial"
    if ( this.$screenContainer.hasClass('initial') )
      this.$screenContainer.removeClass('initial');

    for (var key in this.$screens) {
      var el = this.$screens[key],
          curPos = el.hasClass('active')? 'active' : el.hasClass('right')? 'right' : 'left',
          nextPos;

      if ( (curPos == 'active' && direction == 'right') || (curPos == 'right' && direction == 'left') )
        nextPos = 'left';
      else if ( (curPos == 'left' && direction == 'right') || (curPos == 'active' && direction == 'left') )
        nextPos = 'right';
      else
        nextPos = 'active';

      // do z-index stuff
      if ( curPos == 'active' || nextPos == 'active' ) {
        el.css('z-index', 2);
      } else {
        el.css('z-index', 1);
      }

      this._moveSlide(el, nextPos);

      // add correct class
      el.removeClass(curPos).addClass(nextPos);
    }
  };

  PortfolioSlider.prototype.updateScreen = function(screenName) {
    for (var key in this.$screens) {
      var el = this.$screens[key].children('.screen-inner'),
          fileName = '/assets/port-' + this.siteName + '-' + key + '-' + screenName + '.png',
          image = document.createElement('img');

      image.src = fileName;
      el.html(image);
    }
  };

  PortfolioSlider.prototype.initFullSlider = function() {
    var containerWidth = this.width - this.margin*2,
        containerHeight = this.$screenContainer.height(),
        self = this;

    // we'll want to save screens by device type
    var screens = {};

    // set height, width, and position for all screens
    this.$screens.each(function() {
      var $this = $(this),
          type = $this.data('device'),
          height = self.ratios[type] > 1? containerHeight : containerWidth*self.ratios[type],
          width = self.ratios[type] < 1? containerWidth : containerHeight/self.ratios[type];

      $this.css({
        height: height + 'px',
        width: width + 'px',
        left: containerWidth/2 - width/2 + self.margin + 'px',
        top: containerHeight/2 - height/2 + 'px'
      });

      screens[type] = $this;

    });

    // save new screens object so we can access by device type
    this.$screens = screens;

    // set phone and tablet to be right and left
    self._moveSlide(this.$screens.phone, 'left', 0.6);
    self._moveSlide(this.$screens.tablet, 'right', 0.6);

    // add click event to portfolio nav
    $('.slider-nav').on('click', 'a', function(e) {
      e.preventDefault();

      if ( $(this).hasClass('port-left') ) {
        self.transitionSlides('left');
      } else {
        self.transitionSlides('right');
      }
    });
  };

  PortfolioSlider.prototype.initMobileSlider = function() {
    var containerWidth = this.width,
        self = this;

    // we'll want to save screens by device type
    var screens = {};

    // set height, width, and position for all screens
    this.$screens.each(function() {
      var $this = $(this),
          type = $this.data('device'),
          height = null,
          width = null,
          left = 0,
          top = 0;

      // no tablet view on mobile
      if ( type == 'tablet' ) return true;

      // set mobile and desktop sizes
      if ( type == 'desktop' ) {
        width = containerWidth * 1.2;
        height = width * self.ratios[type];
        left = containerWidth * 0.2;
      } else if ( type == 'phone' ) {
        width = containerWidth * 0.4;
        height = width * self.ratios[type];
        top = height * 0.15;
        left = containerWidth * 0.05;
      }

      $this.css({
        height: height + 'px',
        width: width + 'px',
        left: left + 'px',
        top: top + 'px'
      });

      screens[type] = $this;

    });

    // save new screens object so we can access by device type
    this.$screens = screens;
  };

  PortfolioSlider.prototype.init = function() {
    var self = this;

    // init full slider if not mobile
    if ( Modernizr.mq('only screen and (min-width: ' + small_break + 'px)') ) {
      this.initFullSlider();
    } else {
      this.initMobileSlider();
    }

    // add click event to portfolio thumbs
    this.$thumbs.on('click', '.thumbnail', function(e) {
      e.preventDefault();

      self.$thumbs.find('.thumbnail').removeClass('active');
      $(this).addClass('active');

      var screenName = $(this).data('screen');
      self.updateScreen(screenName);
    });

  };

  if ( $('.port-slider').length > 0 ) {
    var port_slider = new PortfolioSlider('.port-slider');
    port_slider.init();
  }

  // home page hero circles
  var HeroCircles = function(el) {
    this.$el = $(el);
    this.$circles = this.$el.find('.circle');
    this.$expander = this.$el.find('.circle-expander');
    this.$cur_circle = null;
  };

  HeroCircles.prototype._placeBG = function() {

    // get parent position and dimensions
    var self = this,
        parent_pos = this.$el.offset(),
        parent_width = this.$el.width(),
        parent_height = this.$el.height();

    this.$circles.each(function() {
      var $circle = $(this),
          offset = $circle.offset(),
          $bg = $circle.children('.bg');

      // set position
      $bg.css({
        'top': parent_pos.top - offset.top + 'px',
        'left': parent_pos.left - offset.left + 'px',
        'width': parent_width + 'px',
        'height': parent_height + 'px'
      });
    });

  };

  HeroCircles.prototype._animateInTitle = function(delay) {
    var self = this,
        $title = this.$expander.children('.title-overlay'),
        cur_class = this.$cur_circle.data('name'),
        $expander_nav = this.$expander.children('.expander-nav').children('a').not('.' + cur_class);

    TweenLite.set($expander_nav.last(), { x: 160, right: 0,  left: 'auto', delay: delay });
    TweenLite.set($expander_nav.first(), {
      x: -160,
      left: 0,
      right: 'auto',
      delay: delay,
      onComplete: function() {
        // add content to title overlay after delay
        $title.html(self.$cur_circle.siblings('.tagline').html());
      }
    });

    // animate in title overlay
    TweenLite.to($title, 0.5, {
      y: 40,
      delay: delay,
      ease: Back.easeOut
    });

    TweenLite.to($expander_nav, 0.15, {
      x: 0,
      delay: delay + 0.5
    });
  };

  HeroCircles.prototype._animateOutTitle = function() {
    var $title = this.$expander.children('.title-overlay'),
        cur_class = this.$cur_circle.data('name'),
        $expander_nav = this.$expander.children('.expander-nav').children('a').not('.' + cur_class);

    // animate out title overlay
    TweenLite.to($title, 0.5, {
      y: $title.outerHeight()
    });

    // animate out circles
    TweenLite.to($expander_nav.first(), 0.15, {
      x: -160
    });
    TweenLite.to($expander_nav.last(), 0.15, {
      x: 160
    });
  };

  HeroCircles.prototype._animateIn = function(circle) {
    var $circle = $(circle),
        $border = $circle.siblings('.border'),
        img = $circle.children('.bg').data('bg');

    // set current circle
    this.$cur_circle = $circle;

    // set bg image for expander div
    this.$expander.css('z-index', 4);
    this.$expander.children('.bg').css('background-image', 'url(' + img + ')');

    // add active class to li
    $circle.parent('li').addClass('active');

    // expand circle
    TweenLite.to($border, 0.3, {
      scale: 7
    });

    // fade in expander
    TweenLite.to(this.$expander, 0.5, {
      opacity: 1,
      delay: 0.5,
      onComplete: function() {
        TweenLite.set($border, { scale: 1 });
      }
    });

    // animate in title overlay
    this._animateInTitle(1);
  };

  HeroCircles.prototype._animateOut = function() {
    var self = this;

    // remove active class and scale down border
    this.$el.find('li').removeClass('active');

    // animate out title
    this._animateOutTitle();

    // fade out expander
    TweenLite.to(this.$expander, 0.5, {
      opacity: 0,
      delay: 0.5,
      onComplete: function() {
        self.$expander.css({
          'z-index': -1
        });
      }
    });

  };

  HeroCircles.prototype._animateSwitch = function(circle) {
    this._animateOutTitle();

    this.$cur_circle = $(circle);

    var img = this.$cur_circle.children('.bg').data('bg'),
        $bg = this.$expander.children('.bg');

    // switch active class
    this.$el.find('li').removeClass('active');
    this.$cur_circle.parent('li').addClass('active');

    TweenLite.to($bg, 0.3, {
      opacity: 0,
      delay: 0.5,
      onComplete: function() {
        $bg.css('background-image', 'url(' + img + ')');
        TweenLite.to($bg, 0.3, { opacity: 1 });
      }
    });

    this._animateInTitle(1);
  };

  HeroCircles.prototype.init = function() {
    var self = this;

    this._placeBG();

    // add click events
    this.$el.on('click', '.circle', function() {
      self._animateIn(this);
    });
    this.$el.find('.close-btn').on('click', function(e) {
      e.preventDefault();
      self._animateOut();
    });
    this.$expander.children('.expander-nav').on('click', 'a', function(e) {
      e.preventDefault();
      var new_class = $(this).attr('class'),
          $circle = self.$el.find('ul .' + new_class);

      console.log("new class is", new_class, "new circle is", $circle[0]);
      self._animateSwitch($circle);
    });
  };

  var hero_circles = new HeroCircles('.hero-circles');
  hero_circles.init();

  // troop dropdowns
  $('.troop-list').on('click', '.trigger', function(e) {
    e.preventDefault();

    var $this = $(this),
        $li = $this.parent(),
        $troop_list = $this.parents('.troop-list'),
        $dropdown = $this.siblings('.profile-content');

    // if closing the accordion, change classes and be done
    if ($li.hasClass('active')) {
      $li.removeClass('active');
      $troop_list.children('li').removeClass('inactive');
      return;
    }

    $troop_list.children('li').not($li).removeClass('active').addClass('inactive');
    $li.removeClass('inactive').addClass('active');

    // set dropdown top to correct value
    var offset_top = $li.position().top + $li.outerHeight();
    $dropdown.css('top', offset_top + 'px');

  });

  /**************************************
  ** Header Blur on Scroll
  **************************************/

  function BlurHeader(el) {
    this.$el = $(el);
  }

  BlurHeader.prototype.blurImage = function() {
    console.log("blur image");
    this.$image = this.$el.find('.image-bg');
    var self = this;

    this.$image.on('load', function() {

      // position and size image in center
      var containerWidth = self.$el.outerWidth(),
          containerHeight = self.$el.outerHeight(),
          imageWidth = self.$image.width(),
          imageHeight = self.$image.height(),
          width = 0,
          height = 0,
          offsetLeft = 0,
          offsetTop = 0;
      if ( imageWidth/imageHeight > containerWidth/containerHeight ) {
        width = containerHeight * (imageWidth/imageHeight);
        height = containerHeight;
        offsetLeft = -(width - containerWidth)/2;
      } else {
        width = containerWidth;
        height = containerWidth * (imageHeight/imageWidth);
        offsetTop = -(height-containerHeight)/2;
      }

      self.$image.css({
        'width': width + 'px',
        'height': height + 'px',
        'left': offsetLeft + 'px',
        'top': offsetTop + 'px',
        'display': 'block'
      });

      if ( Modernizr.canvas && !Modernizr.touch ) {
        // create and append canvas
        var canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        canvas.style.left = offsetLeft + 'px';
        canvas.style.top = offsetTop + 'px';
        self.$el.append(canvas);

        // set up blurry canvas
        var $window = $(window),
            transitionBlur = new TweenLite.to(canvas, 1, {opacity: 1, paused: true});

        var blurScroll = function() {
          var pos = $window.scrollTop(),
              progress = ( 1/(self.$el.height() - 80) ) * pos;

          // set tween to current progress
          if(progress >= 0 && progress <= 1) {
            transitionBlur.progress(progress);
          }
        };

        stackBlurImage( self.$image[0], canvas, 40, false );
        $window.on('scroll', blurScroll);
      }
    }).each(function() {
      // catch cached images -- seems to be causing it to run twice right now
      //if(this.complete) $(this).load();
    });
  };

  if ($('.blur-image').length > 0 ) {
    var page_header = new BlurHeader('.blur-image');
    page_header.blurImage();
  }

  // contact page map
  if ($('#contact-map').length > 0) {
    var map_styles = [{
        featureType:'landscape',
        elementType:'all',
        stylers:[
          { color:'#dbf1ee' },
          { visibility:'on' }
        ]
      }, {
        featureType:'water',
        elementType:'geometry.fill',
        stylers:[
          { color:'#b4d7e6' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.highway',
        elementType:'geometry.fill',
        stylers:[
          { color:'#69bfb2' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.highway',
        elementType:'geometry.stroke',
        stylers:[
          { color:'#ffffff' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.arterial',
        elementType:'all',
        stylers:[
          { color:'#ffffff' },
          { visibility:'simplified' }
        ]
      }, {
        featureType:'poi.park',
        elementType:'geometry.fill',
        stylers:[
          { color:'#bcca7f' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.local',
        elementType:'all',
        stylers:[
          { color:'#d6ebe8' },
          { visibility:'off' }
        ]
      }, {
        featureType:'poi.attraction',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.place_of_worship',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.government',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.school',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.business',
        elementType:'geometry.fill',
        stylers:[
          { color:'#bcd7d2' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.medical',
        elementType:'geometry',
        stylers:[
          { color:'#e5fbf8' },
          { visibility:'off' }
        ]
      }, {
        featureType:'road',
        elementType:'labels',
        stylers:[
          { hue:'#ffffff' },
          { saturation:-100 },
          { lightness:100 },
          { visibility:'off' }
        ]
      }, {
        featureType:'transit',
        elementType:'labels',
        stylers:[
          { hue:'#ffffff' },
          { saturation:0 },
          { lightness:100 },
          { visibility:'off' }
        ]
      }, {
        featureType:'landscape.man_made',
        elementType:'geometry',
        stylers:[
          { color:'#e6faf8' },
          { visibility:'off' }
        ]
      }, {
        featureType:'administrative.neighborhood',
        elementType:'labels.text.fill',
        stylers:[
          { color:'#42454c' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.local',
        elementType:'all',
        stylers:[
          { color:'#cbe7e3' },
          { visibility:'simplified' }
        ]
      }
    ];
    var office_loc = new google.maps.LatLng(30.383294, -97.743659),
        marker_image = '/images/map-marker.png';
    var map = new google.maps.Map(document.getElementById('contact-map'), {
      zoom: 14,
      center: office_loc,
      'styles': map_styles
    });

    var office_marker = new google.maps.Marker({
      map: map,
      animation: google.maps.Animation.DROP,
      position: office_loc,
      icon: marker_image
    });
    office_marker.setMap(map);
  }

  // shoot bananas from the footer
  function shoot_bananas() {
    console.log("shooting bananas");
    var a = 0.8, // vertical accelleration
        num_bananas = Math.ceil(Math.random() * 4 + 1),
        pos = [0, -20],
        $banana_triangle = $('.bananas');


    // create some bananas and shoot them
    for (var i = 0; i < num_bananas; i++) {
      var banana = $('<div class="shooting-banana" />'),
          vx = (0.5 - Math.random()) * 10, // horizontal velocity, can be positive or negative
          vy = -Math.random() * 20; // initial vertical velocity

      console.log("initial x velocity:", vx + ", initial y velocity:", vy);
      $banana_triangle.append(banana);
      update_banana_pos(banana, pos, vx, vy, a);
    }
  }

  $('.bananas').on('mouseenter', shoot_bananas);

  function update_banana_pos(banana, p0, vx, vy, a) {
    // we're under the assumption that 1 time unit has passed each iteration
    var posX = p0[0] + vx,
        posY = p0[1] + vy,
        transform = 'matrix(1, 0, 0, 1, '+ posX + ', '+ posY +')';

    // update velocity
    vy += a;

    // set the transform
    banana[0].style.webkitTransform = transform;
    banana[0].style.MozTransform = transform;
    banana[0].style.msTransform = transform;
    banana[0].style.OTransform = transform;
    banana[0].style.transform = transform;

    // if posX is greater than 20px below, keep going
    if ( posY < 20) {
      requestAnimationFrame(function() {
        update_banana_pos(banana, [posX, posY], vx, vy, a);
      });
    } else {
      banana.remove();
    }
  }

}(jQuery));
