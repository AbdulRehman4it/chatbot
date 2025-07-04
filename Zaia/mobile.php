<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Zaia</title>
    <link rel="icon" type="image/png" href="./assets/img/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="./assets/img/favicon.svg" />
<link rel="shortcut icon" href="./assets/img/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="./assets/img/apple-touch-icon.png" />
<link rel="manifest" href="./assets/img/site.webmanifest" />
    <link rel="stylesheet" href="./assets/css/style.css">
      <script>
    window.addEventListener("DOMContentLoaded", () => {
  fetchGreetingFromAPI();
});
  </script>
</head>
<body class="bg-[#0E0E0F] lg:hidden block">

  <!-- Header -->
  <div class="flex justify-between items-center px-5 py-5">
    <div><a href="./index.php"><img src="./assets/img/left.png" alt=""></a></div>
    <div class="text-center">
      <h1 class="text-white text-2xl">Z.A.I.A</h1>
      <p class="text-sm text-[#777777]">Zero Artificial Intimacy Agent</p>
    </div>
    <div><a href="#"><img src="./assets/img/dot.png" class="2xl:w-[6px] 2xl:h-7 h-5 w-[4px]" alt=""></a></div>
  </div>
  <hr class="border-[1px] border-[#252323]">

  <!-- Chat Body -->
  <div id="chatBody" class="px-5 pt-5 space-y-6 overflow-y-auto pb-28"></div>

  <!-- Chat Input -->
  <div class="fixed bottom-0 left-0 right-0 bg-[#0E0E0E] pt-4 pb-6">
    <hr class="border-[1px] border-[#252323]">
    <div class="mt-4 px-6 flex items-center gap-4">
     
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



  <script src="https://kit.fontawesome.com/a2ada4947c.js" crossorigin="anonymous"></script>
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
</body>

</html>