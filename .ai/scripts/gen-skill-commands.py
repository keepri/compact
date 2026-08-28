import os, re, pathlib, glob

skills_dir = pathlib.Path('.opencode/skills')
cmds_dir = pathlib.Path('.opencode/commands')
cmds_dir.mkdir(exist_ok=True)
existing = {p.name[:-3] for p in cmds_dir.glob('*.md')}

def parse_frontmatter(text):
    m = re.match(r'^---\n(.*?)\n---', text, re.S)
    if not m:
        return {}
    fm = m.group(1)
    keys = {}
    # find all top-level keys: lines starting with a non-space word + colon
    lines = fm.split('\n')
    i = 0
    while i < len(lines):
        line = lines[i]
        km = re.match(r'^([A-Za-z_][\w-]*):\s*(.*)$', line)
        if not km:
            i += 1
            continue
        k, rest = km.group(1), km.group(2)
        # block scalar
        if rest in ('>', '|', '>-', '|-') or rest.startswith('>'):
            # gather following indented lines
            j = i + 1
            chunk = []
            while j < len(lines) and (lines[j].startswith('  ') or lines[j].strip()=='' ):
                if lines[j].strip()=='':
                    chunk.append('')
                else:
                    chunk.append(lines[j][2:])
                j += 1
            keys[k] = ' '.join(x.strip() for x in chunk if x.strip())
            i = j
        else:
            keys[k] = rest.strip()
            i += 1
    return keys

created = 0
for skill_dir in sorted(pathlib.Path('.opencode/skills').iterdir()):
    if not skill_dir.is_dir():
        continue
    name = skill_dir.name
    if name in existing:
        continue
    sf = skill_dir / 'SKILL.md'
    if not sf.exists():
        continue
    fm = parse_frontmatter(sf.read_text())
    desc = fm.get('description', '')
    desc_oneline = ' '.join(desc.split())
    content = (f'---\ndescription: {desc_oneline}\n---\n\n'
               f'Invoke the "{name}" skill. Load and follow its instructions now.')
    (cmds_dir / f'{name}.md').write_text(content)
    created += 1

print('created', created, 'command stubs')
print('total commands now:', len(list(cmds_dir.glob('*.md'))))
