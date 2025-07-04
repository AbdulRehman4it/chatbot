<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zaia</title>
    <link rel="icon" type="image/png" href="./assets/img/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="./assets/img/favicon.svg" />
<link rel="shortcut icon" href="./assets/img/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="./assets/img/apple-touch-icon.png" />
<link rel="manifest" href="./assets/img/site.webmanifest" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <style>
      #disclaimerBar {
  transition: opacity 0.3s ease;
}
      #chatBody {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE and Edge */
}

#chatBody::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}
    </style>
  </head>
  <body class="bg-[#0E0E0F]">
<section class="lg:block hidden">
      <div class="font-sans bg-[#0E0E0E] flex">
        <!-- Vertical Sidebar (Left Side) -->
        <div
          class="fixed left-0 top-0 w-28 flex flex-col items-center justify-between pt-6 border-r border-[#252323] sticky"
        >
          <div class="flex flex-col gap-16 items-center">
            <!-- Top logo -->
            <div class="text-3xl font-bold">
              <img src="./assets/img/logo.png" alt="" />
            </div>

            <!-- Middle Icons -->
            <div class="flex flex-col gap-6">
              <div>
                <a href=""
                  ><img
                    src="./assets/img/not.png"
                    class="2xl:w-8 2xl:h-8 w-7 h-7"
                    alt=""
                /></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Main App Layout -->
        <div class="flex-1 flex flex-col">
          <!-- 🔝 Top Navbar (Right Corner Icons) -->
          <div
            class="w-full bg-[#0E0E0E] flex justify-end items-center px-6 gap-4 border-b border-[#252323] py-5"
          >
            <a href="https://x.com/Zaia_KB" target="_blank"
              ><img
                src="./assets/img/tiwitter.png"
                class="h-10 w-10 xl:h-full xl:w-full"
                alt=""
            /></a>
            <a href="https://kinkybunny.com/" target="_blank"
              ><img
                src="./assets/img/cat.png"
                class="h-10 w-10 xl:h-full xl:w-full"
                alt=""
            /></a>
          </div>

          <!-- 👇 Main Content (placeholder for chat, etc.) -->
          <div class="flex-1 flex">
            <!-- Sidebar Content (Recent Chats) -->
            <aside
              class="w-80 h-[calc(90vh-80px)] p-4 hidden md:block border my-4 mx-4 rounded-2xl border-[#252323]"
            >
            
              <h1 class="text-2xl xl:text-3xl mb-5 text-white">RECENT CHATS</h1>
              <hr class="border-[1px] border-[#252323]" />
              <button id="newChatBtn"
                class="bg-[#5A44E9] text-lg text-white w-full py-3 rounded-full font-semibold mb-4 flex items-center justify-center gap-5 mt-5"
              >
                New Chat
                <img src="./assets/img/cht.png" alt="" />
              </button>
              <!-- From Uiverse.io by sudhucodes -->
            </aside>
<script>
document.getElementById("newChatBtn").addEventListener("click", function () {
  chatBody.innerHTML = "";
  fetchGreetingFromAPI();
});
</script>
            <!-- Main Chat Section (Placeholder) -->
<main class="flex flex-col h-[calc(90vh-80px)] w-full border border-[#252323] my-4 rounded-2xl 2xl:mr-10 md:mr-5 bg-[#0E0E0E]">

  <!-- Top Section (Title + Avatar) -->
  <div class="p-6">
    <div class="flex justify-between items-center">
      <div class="flex items-center gap-4 rounded-full">
        <img src="./assets/img/zaia.jpg" class="2xl:w-20 2xl:h-20 h-14 w-14 rounded-full" alt="" />
        <div>
          <h1 class="text-white text-2xl">Z.A.I.A</h1>
          <p class="text-sm text-[#777777]">Zero Artificial Intimacy Agent</p>
        </div>
      </div>
      <div>
        <a href="">
          <img src="./assets/img/dot.png" class="2xl:w-[6px] 2xl:h-7 h-5 w-[4px]" alt="" />
        </a>
      </div>
    </div>
    <hr class="border-[1px] border-[#252323] mt-4" />
  </div>

  <!-- Chat Body (scrollable & always full width) -->
  <div id="chatBody" class="flex-1 overflow-y-auto px-6 py-4 space-y-6 w-full"></div>

  <hr class="border-[1px] border-[#252323]" />

  <!-- Chat Input (fixed bottom inside main) -->
  <div class="px-6 py-4 bg-[#0E0E0E] w-full">
    <div class="flex items-center gap-4">
      <div class="relative flex-1">
        <input
          id="userInput"
          type="text"
          placeholder="Start your chat.."
          class="w-full px-4 pr-20 py-2 rounded-full bg-[#161617] text-white placeholder-[#777777] focus:outline-none"
        />
       
      </div>

      <button id="sendBtn" class="bg-[#5A44E9] w-10 h-10 flex items-center justify-center rounded-full">
        <i class="fas fa-paper-plane text-white"></i>
      </button>
    </div>
  </div>

</main>


          </div>
        </div>
      </div>
    </section>

    <section class="lg:hidden md:block">
      <!-- Navbar -->
      <header
        class="flex items-center justify-between px-5 py-5 border-b border-[#252323]"
      >
        <div><img src="./assets/img/mobilelogo.png" alt="" /></div>
        <!-- Hamburger Toggle -->
        <div
          id="toggleBtn"
          class="space-y-1 absolute right-5 z-50 cursor-pointer lg:hidden"
        >
          <div class="w-6 h-0.5 bg-white line line1"></div>
          <div class="w-6 h-0.5 bg-white line line2"></div>
          <div class="w-6 h-0.5 bg-white line line3"></div>
        </div>
      </header>

      <!-- Sidebar (Mobile) -->
      <aside
        id="mobileMenu"
        class="fixed top-0 left-0 w-full h-full bg-[#1a1a1a] transform -translate-x-full transition-transform duration-300"
      >
        <div class="p-6">
          <div class="pb-5">
            <img src="./assets/img/mobilelogo.png" alt="" />
          </div>
          <hr class="border-[1px] border-[#252323]" />
          <ul class="space-y-8 pt-5">
            <li>
              <a
                href="#"
                class="block hover:text-white flex items-center gap-4 text-white font-light"
                ><img
                  src="./assets/img/not.png"
                  class="w-6"
                  alt=""
                />Conversations</a
              >
            </li>
          </ul>
        </div>
      </aside>

      <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div> 

      <!-- Content -->
      <aside class="w-full p-4 block lg:hidden my-4">
        <h1 class="text-2xl xl:text-3xl mb-5 text-white">RECENT CHATS</h1>
        <hr class="border-[1px] border-[#252323]" />
        <a href="./mobile.php">
          <button
            class="bg-[#5A44E9] text-lg text-white w-full py-3 rounded-full font-semibold mb-4 flex items-center justify-center gap-5 mt-5"
          >
            New Chat
            <img src="./assets/img/cht.png" alt="" />
          </button>
        </a>
        

      
      </aside>
    </section>
     <script>
      const toggleBtn = document.getElementById("toggleBtn");
      const mobileMenu = document.getElementById("mobileMenu");
      const overlay = document.getElementById("overlay");

      toggleBtn.addEventListener("click", () => {
        toggleBtn.classList.toggle("toggle-active");
        mobileMenu.classList.toggle("-translate-x-full");
        overlay.classList.toggle("hidden");
      });

      overlay.addEventListener("click", () => {
        toggleBtn.classList.remove("toggle-active");
        mobileMenu.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
      });
    </script>




   <script>
    function scrollToBottom() {
  const chat = document.getElementById("chatBody");
  chat.scrollTop = chat.scrollHeight;
}
const sendBtn = document.getElementById("sendBtn");
const userInput = document.getElementById("userInput");
const chatBody = document.getElementById("chatBody");

const agentId = "1acefbf8-6b7c-4ef9-af9e-32dc00029a48";





sendBtn.addEventListener("click", () => sendPrompt(userInput.value));
userInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") sendPrompt(userInput.value);
});


function generateUUID() {
  return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
  );
}


function getCookie(name) {
  const match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
  return match ? decodeURIComponent(match[2]) : null;
}

function setCookie(name, value) {
 const expiryInSeconds = 1200; 
  document.cookie = `${name}=${value}; path=/; max-age=${expiryInSeconds}`;
}

function ensureCookie(name, generatorFn) {
  if (!getCookie(name)) {
    setCookie(name, generatorFn());
  }
}

ensureCookie("userId", () => "guest-" + generateUUID());
setCookie("sessionId", generateUUID());



function appendUserMessage(msg) {
  chatBody.innerHTML += `<div class="flex justify-end">
    <div class="bg-white text-black px-6 py-2 text-sm rounded-full max-w-xl">${msg}</div>
    <img src="./assets/img/zcomment.png" class="w-10 h-10 rounded-full ml-3"/>
  </div>`;
   scrollToBottom();
}

function appendAgentMessage(msg) {
  chatBody.innerHTML += `<div class="flex gap-3">
    <img src="./assets/img/zaia.jpg" class="w-10 h-10 rounded-full ml-3" />
    <div class="bg-[#1E1E1E] text-[#777777] text-sm px-6 py-2 rounded-full max-w-3xl">${msg}</div>
  </div>`;
   scrollToBottom();
}

function addTyping() {
  chatBody.innerHTML += `
    <div id="agentTyping" class="flex gap-3 animate-pulse">
      <img src="./assets/img/zaia.jpg" class="w-10 h-10 rounded-full ml-3" />
      <div class="bg-[#1E1E1E] text-[#777777] text-sm px-6 py-2 rounded-full max-w-3xl">
      Sit tight, babe — Zaia’s decoding your mood as we speak 😏
      </div>
    </div>`;
     scrollToBottom();
}

function removeTyping() {
  document.getElementById("agentTyping")?.remove();
}



async function sendPrompt(prompt) {
  const cleaned = prompt.trim();
  if (!cleaned) return;

  appendUserMessage(cleaned);
  userInput.value = "";
  addTyping();
 
  const userId = getCookie("userId");
  const sessionId = getCookie("sessionId");

  if (!userId || !sessionId) {
    removeTyping();
    appendAgentMessage("⚠️ Missing userId or sessionId in cookies.");
   
    return;
  }

  try {
    const res = await fetch("proxy.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        agentId,
        userId,
        sessionId,
        prompt: cleaned,
      }),
    });

    if (!res.ok) {
      const text = await res.text();
      throw new Error(`HTTP error ${res.status}: ${text}`);
    }

    const data = await res.json();
    removeTyping();

    if (!data || !data.response) {
      appendAgentMessage("⚠️ No response from ZAIA. Try again.");
      return;
    }

    const resp = data.response;
    if (typeof resp === "string") {
      if (resp.includes("Name:") && resp.includes("Link:")) {
        renderProfilesFromText(resp);
      } else if (resp.includes("onlyfans.com")) {
        renderProfilesFromLooseText(resp);
      } else {
        appendAgentMessage(resp);
      }
    } else if (Array.isArray(resp)) {
      renderProfiles(resp);
    } else {
      appendAgentMessage("⚠️ Unexpected response format.");
    }
  } catch (err) {
    removeTyping();
    console.error("❌ Error:", err);
    appendAgentMessage("Oops, something went wrong 😬");
  }
  
}


function renderProfilesFromText(text) {
  const profilePattern = /Name:\s*(.+?)\s+Link:\s*(https?:\/\/[^\s]+)\s+Bio:\s*([\s\S]*?)(?:\s+Image:\s*(https?:\/\/[^\s]+))?(?=\s+Name:|$)/g;
  const profiles = [];
  let match;

  while ((match = profilePattern.exec(text)) !== null) {
    const name = match[1]?.trim() || "Unknown";
    const link = match[2]?.trim() || "#";
    let bio = match[3]?.replace(/Image:\s*https?:\/\/\S+/gi, '').trim() || "No bio available";
if (bio.split(/\s+/).length > 25) {
  bio = bio.split(/\s+/).slice(0, 25).join(" ") + "…";
}
const tagPattern = /\b(joi|feet|dom|sub|dildo|cum|porn|sexting|hucow|latex|fetish|milf|daddy|solo|orgy|anal|bdsm|kink|blowjob|threesome|toys|nude|rated|wet|lesbian|gay|girl-on-girl|cock|pussy|masturbat(e|ion)|onlyfans)\b/gi;
const tags = bio.match(tagPattern) || [];
    const image = match[4]?.trim() || "https://kinkybunny.app/Zaia/assets/img/loader.png";
    if (bio.split(/\s+/).length > 25) bio = bio.split(/\s+/).slice(0, 25).join(" ") + "…";
    profiles.push({ name, link, bio, image, tags });
  }

  if (!profiles.length) {
    appendAgentMessage("😶 Couldn't format any valid profiles.");
    return;
  }

  renderProfileCards(profiles);
}

function renderProfilesFromLooseText(text) {
  const profilePattern = /([\w\s💞🍒🌍🖤🥵🥰😇]+)\s+(https:\/\/onlyfans\.com\/[^\s]+)\s+([^]+?)(?=\s+\w+\s+https:\/\/onlyfans\.com\/|$)/g;
  const profiles = [];
  let match;

  while ((match = profilePattern.exec(text)) !== null) {
    const name = match[1]?.trim() || "Unknown";
    const link = match[2]?.trim() || "#";
    let bio = match[3]?.replace(/Image:\s*https?:\/\/\S+/gi, '').trim() || "No bio available";
if (bio.split(/\s+/).length > 25) {
  bio = bio.split(/\s+/).slice(0, 25).join(" ") + "…";
}
const tagPattern = /\b(joi|feet|dom|sub|dildo|cum|porn|sexting|hucow|latex|fetish|milf|daddy|solo|orgy|anal|bdsm|kink|blowjob|threesome|toys|nude|rated|wet|lesbian|gay|girl-on-girl|cock|pussy|masturbat(e|ion)|onlyfans)\b/gi;
const tags = bio.match(tagPattern) || [];
    const image = "https://kinkybunny.app/Zaia/assets/img/loader.png";
    if (bio.split(/\s+/).length > 25) bio = bio.split(/\s+/).slice(0, 25).join(" ") + "…";
    profiles.push({ name, link, bio, image });
  }

  if (!profiles.length) {
    appendAgentMessage("😶 Couldn't extract any creator profiles.");
    return;
  }

  renderProfileCards(profiles);
}

function renderProfileCards(profiles) {
  let html = '<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 px-6 lg:px-20">';
  profiles.forEach((p) => {
    html += `
      <div class="bg-[#161616] rounded-2xl p-4 space-y-2 min-w-[250px]">
        <img src="image-proxy.php?url=${encodeURIComponent(p.image)}" class="rounded-xl w-full h-48 object-cover mb-4" />
        <p><span class="text-[#777777]">Name:</span> <span class="text-white">${p.name}</span></p>
        <p><span class="text-[#777777]">Platform:</span> <span class="text-white">OnlyFans</span></p>
        <p class="text-sm text-[#777777]">Bio:</p>
        <p class="text-sm text-white italic">${p.bio}</p>
        ${p.tags?.length ? `
  <div class="flex flex-wrap gap-2 pt-2">
    ${p.tags.map(tag => `<span class="text-xs bg-[#5A44E9] text-white px-3 py-1 rounded-full">${tag}</span>`).join('')}
  </div>` : ''}
        <div class="flex justify-between items-center pt-5">
          <a href="${p.link}" target="_blank" class="bg-white text-black px-4 py-2 rounded-full font-semibold text-sm">View Profile</a>
        </div>
      </div>`;
  });
  html += "</div>";
  chatBody.innerHTML += html;
}

async function fetchGreetingFromAPI() {
  const greetings = [
    "Hey babe 😘 What vibe are we feeling today? Give me a word.",
    "Hi sweetie 💋 What’s your mood right now? Drop a keyword and I’ll do the rest.",
    "Well, well… look who’s here 👀 What kind of energy are we chasing today?",
    "Hey there 😏 Gimme a word—soft, bold, wild... whatever you're into.",
    "Mmm, you caught me at the perfect time 😇 What’s the flavor you’re craving?",
    "Hello gorgeous 🌶 What kind of mood are we in? One word is all I need.",
    "Hey sugar 💖 What vibe are we diving into? Just say the word.",
    "Hi babe ! 😌 What’s your vibe today?",
    "Hi hot stuff 🔥 Let me know what you're into—just one word will do.",
    "Hey cutie 💫 What are you in the mood to explore? Drop me a hint.",
    "Looking for trouble again, huh? 😈 What’s the mood today?",
    "Welcome, babe 😍 What kind of vibe are we playing with?",
    "What are you in the mood to uncover, love? 😘 Just say the vibe.",
    "Hey you 😏 Give me your mood, your kink, your keyword—I'm listening.",
    "You rang? 😋 Tell me your vibe and I’ll bring the heat.",
    "Zaia at your service 💋 Give me a mood or keyword and I’ll find your match.",
    "Just you and me now 😇 What energy are we channeling today?",
    "Hi darling ✨ Drop a keyword—I'll turn it into magic.",
    "Mmm, I’ve got something for every mood 😉 What are you craving?",
    "Let’s get to it, shall we? 😌 What vibe are we chasing?"
  ];

  const randomIndex = Math.floor(Math.random() * greetings.length);
  const randomGreeting = greetings[randomIndex];

  // Optional tiny delay for async simulation
  await new Promise(resolve => setTimeout(resolve, 100));

  appendAgentMessage(randomGreeting);
}
</script>
<script
      src="https://kit.fontawesome.com/a2ada4947c.js"
      crossorigin="anonymous"
    ></script>
    <!-- Age Verification Popup -->
<!-- Adult Content Warning Popup -->
<div id="agePopup" class="fixed inset-0 bg-black bg-opacity-80 z-50 flex items-center justify-center">
  <div class="bg-[#111112] text-white p-8 rounded-[32px] text-center space-y-6 max-w-md w-full mx-4 shadow-xl">
    
    <!-- 18+ Icon -->
    <div class="flex justify-center">
      <img src="./assets/img/18.png" alt="18+" class="w-14 h-14" />
    </div>

    <!-- Heading -->
    <h2 class="text-2xl font-semibold tracking-wide uppercase">Adult Content Warning</h2>

    <!-- Description -->
    <p class="text-sm text-[#999999] leading-relaxed px-2">
      This experience includes adult content for users 18+. By continuing, you agree to our 
      <a href="https://kinkybunny.com/terms-and-condition/" class="underline">Terms</a> and 
      <a href="https://kinkybunny.com/privacy-policies/" class="underline">Privacy Policy</a>, and confirm you're comfortable with mature themes.
    </p>

    <!-- Buttons -->
    <div class="flex justify-center gap-4 pt-2">
      <button
        id="confirmAgeBtn"
        class="bg-[#6B4EFF] hover:bg-[#5A44E9] text-white text-sm font-semibold px-6 py-2 rounded-full shadow-lg shadow-[#6b4eff]/40 transition duration-200"
      >
        I’m 18+
      </button>
      <button
        id="exitBtn"
        class="border border-[#444] text-[#ccc] text-sm font-semibold px-6 py-2 rounded-full hover:border-white hover:text-white transition duration-200"
      >
        Exit
      </button>
    </div>
  </div>
</div>

<script>
  window.addEventListener("DOMContentLoaded", () => {
    const agePopup = document.getElementById("agePopup");
    const confirmAgeBtn = document.getElementById("confirmAgeBtn");
    const exitBtn = document.getElementById("exitBtn");
    const chatBody = document.getElementById("chatBody");
confirmAgeBtn.addEventListener("click", () => {
  agePopup.style.display = "none";
  chatBody.innerHTML = ""; // clear chat
  fetchGreetingFromAPI();
});

    exitBtn.addEventListener("click", () => {
      window.location.href = "https://kinkybunny.com/"; // or your exit route
    });
  });
</script>
<div id="disclaimerBar" class="w-full bg-[#1A1A1A] text-xs text-[#777777] px-6 py-4 flex flex-col items-center md:flex-row md:justify-between gap-3"">
  <p class="text-center md:text-left leading-relaxed">
    Zaia is a product of <span class="text-white font-semibold">KinkyBunny</span>. It is not affiliated with, endorsed by, or connected to platforms like 
    <span class="text-white">OnlyFans</span>, <span class="text-white">Fansly</span>, or <span class="text-white">MyM</span>. Zaia recommends real creator profiles from publicly available data, but does not host or monetize third-party content.<br class="block md:hidden">
    By using Zaia, you agree to 
    <a href="https://kinkybunny.com/privacy-policies/" class="text-white underline hover:text-[#5A44E9]">KinkyBunny’s Terms and Conditions</a>.
  </p>
  <button id="closeDisclaimer" class="text-white text-lg hover:text-[#5A44E9] self-end md:self-center">
    &times;
  </button>
</div>
<script>
  document.getElementById("closeDisclaimer").addEventListener("click", () => {
    document.getElementById("disclaimerBar").style.display = "none";
  });
</script>
  </body>
</html>
