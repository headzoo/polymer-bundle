import sys
import os
import shlex

from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer
from pygments.lexers.data import YamlLexer
from pygments.lexers.templates import TwigHtmlLexer
from pygments.lexers.templates import CheetahHtmlLexer

lexers['php'] = PhpLexer(startinline=True, linenos=1)
lexers['php-annotations'] = PhpLexer(startinline=True, linenos=1)
lexers['yaml'] = YamlLexer()
lexers['twig'] = TwigHtmlLexer()
lexers['html'] = CheetahHtmlLexer()

extensions = [
    'sphinx.ext.autodoc',
    'sphinx.ext.todo',
    'sphinx.ext.ifconfig',
]

templates_path = ['_templates']
source_suffix = '.rst'
master_doc = 'index'
project = u'Polyphonic Polymer Bundle'
copyright = u'2015, Sean Hickey'
author = u'Sean Hickey'
version = '0.0.4'
release = '0.0.4'
language = "en"
exclude_patterns = ['_build']
pygments_style = 'sphinx'
todo_include_todos = True
html_title = "Polyphonic Polymer Bundle"
html_short_title = "Polyphonic"
html_static_path = ['_static']
htmlhelp_basename = 'PolyphonicPolymerBundledoc'

latex_documents = [
  (master_doc, 'PolyphonicPolymerBundle.tex', u'Polyphonic Polymer Bundle Documentation',
   u'Sean Hickey', 'manual'),
]

man_pages = [
    (master_doc, 'polyphonicpolymerbundle', u'Polyphonic Polymer Bundle Documentation',
     [u'Sean Hickey'], 1)
]

on_rtd = os.environ.get('READTHEDOCS', None) == 'True'
if not on_rtd:  # only import and set the theme if we're building docs locally
    import sphinx_rtd_theme
    html_theme = 'sphinx_rtd_theme'
    html_theme_path = [sphinx_rtd_theme.get_html_theme_path()]
    