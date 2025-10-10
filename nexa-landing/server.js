// server.js
const { spawn } = require("child_process");

// Start Nuxt in production mode
const child = spawn("npm", ["run", "start"], {
  stdio: "inherit",
  shell: true
});

child.on("close", (code) => process.exit(code));