-- =====================================================
-- Object:  Table [dbo].[Notas]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Notas] (
    [id] [int] IDENTITY(1,1) NOT NULL,
    [titulo] [varchar](255) NOT NULL,
    [descripcion] [text] NOT NULL,
    [fecha] [datetime] NULL DEFAULT GETDATE(),
    [usuario_id] [int] NULL,
	
    CONSTRAINT PK_Notas PRIMARY KEY CLUSTERED ([id] ASC),
    CONSTRAINT FK_Notas_Usuarios FOREIGN KEY ([usuario_id]) 
        REFERENCES [dbo].[Usuarios] ([ID])
) 
ON [PRIMARY] 
TEXTIMAGE_ON [PRIMARY];