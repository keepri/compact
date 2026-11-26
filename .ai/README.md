# `.ai/`

Source of truth for AI-agent tooling in this project. `.claude/` and
`.opencode/` hold only config plus (when there's real content to link to)
symlinks into this directory — they never hold the actual files themselves.

## Contents

- `plugins/ponytail` — git submodule, vendors the [ponytail](https://github.com/DietrichGebert/ponytail)
  Claude Code plugin pinned to a tag.
- `plugins/mattpocock-skills` — git submodule, vendors [mattpocock/skills](https://github.com/mattpocock/skills)
  pinned to a tag.
- `plugins/caveman` — git submodule, vendors [caveman](https://github.com/JuliusBrussee/caveman)
  pinned to a tag.

  All three registered via `.claude/settings.json`'s `extraKnownMarketplaces`
  (local directory source) + `enabledPlugins`.

  After cloning this repo: `git submodule update --init`.

## opencode

opencode is wired directly to this directory (`/.opencode` is committed, not
gitignored). Source of truth stays here; `.opencode/` holds only the plugin
config plus symlinks back into `.ai/`. Two distinct things are wired:

**Plugins (opencode JS runtime)** — registered in `opencode.json`'s `plugin`
array, pointed at each plugin's real opencode plugin file so its relative
requires and hooks resolve in place:

- `ponytail` → `./.ai/plugins/ponytail/.opencode/plugins/ponytail.mjs`
  (intensity mode + slash commands + skills dir).
- `caveman` → `./.ai/plugins/caveman/src/plugins/opencode/plugin.js`
  (terse-mode state machine + natural-language toggles + reinforcement).
- `mattpocock-skills` → ships no runtime plugin; consumed as skills only.

**Slash commands** — `.opencode/commands/` symlinks the plugin command
templates: `ponytail/.opencode/command/*.md` and
`caveman/src/plugins/opencode/commands/*.md`.

**Skills → commands.** opencode does not auto-expose skills as `/commands` the
way Claude Code does — a skill is only reachable through the `skill` tool. So
every skill without a command file gets a thin `.opencode/commands/<name>.md`
stub (generated, not a symlink) whose `description:` is copied from the
skill's frontmatter and whose body tells the agent to load and run that skill.
This makes `/grill-me`, `/tdd`, etc. appear as suggestions. Regenerate after updating the
submodules from the repo root with `python3 .ai/scripts/gen-skill-commands.py`
(it derives each skill's description and writes a stub for every skill name
that lacks a command).

**Skills** — `.opencode/skills/` holds symlinks to every SKILL.md-based skill
so they're always available as skills regardless of plugin behaviour: the
repo's own (`../../.ai/skills/<name>`) plus every plugin's canonical
`skills/` dir (e.g. `../../.ai/plugins/mattpocock-skills/skills/engineering/<name>`).

For parity with this, `.claude/settings.json` still registers the same three
plugins as Claude Code marketplaces (its native mechanism).

## Adding commands / skills / agents / rules

Don't scaffold empty directories here ahead of need. When you add the first
one, create the real file under the matching `.ai/` subdirectory, then symlink
it from `.claude/`:

```bash
# skills
ln -s ../../.ai/skills/<name> .claude/skills/<name>

# rules
ln -s ../.ai/rules .claude/rules

# commands / agents (undocumented but Claude Code just reads the path)
ln -s ../.ai/commands .claude/commands
ln -s ../.ai/agents .claude/agents
```

`AGENTS.md` at the repo root stays a plain, physical file — it's read directly
(no `@import` support) by several other tools (Codex, Amp, Jules, Copilot CLI,
opencode), so it isn't part of this convention.
