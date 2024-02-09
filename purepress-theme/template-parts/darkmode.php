<?php
/**
 * Template part for display for toggle dark mode button
 *
 */
?>
<?php
function toggle_switch_btn_function()
{
   // Initialize
   $output = '
    <div class="toggle-button mb-0 d-flex">
    <input type="checkbox" class="checkbox" id="checkbox">
    <label for="checkbox" class="checkbox-label">
       <i class="fas fa-sun z-3">
          <svg version="1.0" width="25px" height="25px" viewBox="0 0 150.000000 150.000000"
             preserveAspectRatio="xMidYMid meet">
             <g transform="translate(0.000000,120.000000) scale(0.100000,-0.100000)" fill="#f39c12" stroke="none">
                <path d="M471 986 c-7 -8 -11 -34 -9 -58 3 -42 4 -43 38 -43 34 0 35 1 38 43 2 24 -2 50 -9 58 -15 18 -43 18 -58 0z"> </path>
                <path d="M147 852 c-24 -26 -21 -36 18 -71 37 -32 58 -32 75 0 8 14 4 26 -21 54 -35 40 -49 43 -72 17z"> </path>
                <path d="M781 835 c-32 -37 -32 -58 0 -75 14 -8 26 -4 54 21 40 35 43 49 17 72 -26 24 -36 21 -71 -18z"> </path>
                <path  d="M407 776 c-94 -35 -164 -110 -188 -201 -26 -96 13 -231 84 -291 64 -54 106 -69 197 -69 68 0 93 5 126 22 63 34 97 66 129 125 27 47 30 63 30 138 0 75 -3 91 -30 138 -52 95 -130 143 -240 149 -44 2 -84 -2 -108 -11z"> </path>
                <path d="M12 528 c-34 -34 -2 -71 60 -66 42 3 43 4 43 38 0 34 -1 35 -45 38 -26 2 -50 -2 -58 -10z"></path>
                <path d="M884 526 c-3 -8 -4 -25 -2 -38 3 -20 8 -23 52 -23 56 0 80 21 60 53 -15 23 -102 30 -110 8z"></path>
                <path d="M162 215 c-39 -36 -39 -55 2 -79 14 -9 23 -4 52 27 28 30 33 41 25 56 -18 33 -40 32 -79 -4z"></path>
                <path d="M770 230 c-23 -23 -18 -40 25 -80 20 -19 30 -22 42 -14 35 22 39 42 13 69 -40 43 -57 48 -80 25z"></path>
                <path d="M464 107 c-10 -28 1 -90 19 -101 31 -20 52 4 52 60 0 48 -1 49 -33 52 -21 2 -34 -2 -38 -11z"></path>
             </g>
          </svg>
       </i>
 
       <i class="fas fa-moon z-3">
          <svg version="1.0" width="25px" height="25px" viewBox="0 0 150.000000 150.000000"
             preserveAspectRatio="xMidYMid meet">
             <g transform="translate(50.000000,120.000000) scale(0.100000,-0.100000)" fill="#fff" stroke="none">
                <path
                   d="M310 849 c-78 -43 -126 -93 -168 -178 -35 -71 -37 -80 -37 -171 0 -91 2 -100 37 -172 45 -91 103 -147 196 -191 61 -29 76 -32 162 -32 85 0 102 3 160 31 36 17 80 44 99 60 34 28 91 				100 91 114 0 5 -17 4 -37 -1 -95 -22 -210 1 -304 62 -65 41 -134 133 -156 208 -22 74 -21 186 1 246 10 25 16 48 14 50 -2 2 -28 -10 -58 -26z">
                </path>
             </g>
          </svg>
       </i>
       <span class="ball"></span>
    </label>
 </div>
    ';

   echo $output;
}

// Register the shortcode
add_shortcode('toggle_switch_btn', 'toggle_switch_btn_function');